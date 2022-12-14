<?php
namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Events\CompanyMessaged;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Musonza\Chat\Facades\ChatFacade as Chat;
use Musonza\Chat\Models\Conversation;
use Musonza\Chat\Models\Message;
use Musonza\Chat\Models\Participation;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class ConversationController extends Controller
{

    public function index(Request $request)
    {
        $data = Chat::conversations()->setParticipant(auth()->user()->organisation)
            ->limit(1000)
            ->get()
            ->map(function ($item) {

            $participants = $item->conversation->getParticipants();
            if ($participants) {
                $aryParticipants = [];
                foreach ($participants as $user) {
                    $aryParticipants[] = [
                        'id' => $user->id,
                        'name' => $user->organisation_name,
                        'logo' => optional($user->logo)->image_url
                    ];
                }
            }
            $item->chat_users = $aryParticipants;
            return $this->conversationMapper($item);
        });

        $responseData = $archivedResponseData = [];

        $now = Carbon::now();
        foreach ($data as $item) {
            $diff = $item->conversation->updated_at->diffInDays($now);
            if ($diff >= 15) {
                $archivedResponseData[] = $item;
            }else{
                $responseData[] = $item;
            }
        }

        if($request->get('archived')){
            return response()->json($archivedResponseData);
        }else{
            return response()->json($responseData);
        }
    }

    public function show($id)
    {
        $participantModel = auth()->user()->organisation;

        $conversationData = Chat::conversations()->getById($id);

        if ($conversationData) {
            Chat::conversation($conversationData)->setParticipant($participantModel)->readAll();

            $conversation = Chat::conversation($conversationData)->setParticipant($participantModel)
                ->limit(300)
                ->setPaginationParams([
                'sorting' => 'desc'
            ])
                ->getMessages()
                ->items();

            return $this->returnResponse($conversation, 200, "");
        } else {
            return $this->returnResponse([], 404, __('resources.not-found'));
        }
    }

    public function startChat(Request $request)
    {
        if (isset($request->product_id)) {

            $product = Product::findOrFail($request->product_id);
            $seller = $product->organisation;
        }

        $buyer = auth()->user()->organisation;

        if (isset($buyer) && isset($seller)) {
            $participants = [
                $buyer,
                $seller
            ];

            $conversationExists = Chat::conversations()->between($buyer, $seller);

            if ($conversationExists) {
                $conversation = $conversationExists;
            } else {
                $conversation = Chat::createConversation($participants)->makePrivate()->makeDirect();
            }

            $conversationData = Chat::conversations()->getById($conversation->id);
            if ($request->filled('message')) {
                $message[] = Chat::message($request->get('message'))->from($buyer)
                    ->to($conversationData)
                    ->send();
            }

            $conversationData->participants = $conversationData->getParticipants();

            return response()->json([
                'conversationData' => $conversationData
            ]);
        } else {
            return $this->returnResponse([], 404, __('resources.not-found'));
        }
    }

    public function sendMessage(Request $request, Conversation $conversation)
    {
        $message = [];
        $lastMessage = $conversation->last_message;
        $user = auth()->user();

        // dd($user->organisation);

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            $path = Storage::disk('public')->put('attachments/chat', $file);

            $message[] = Chat::message(json_encode([
                'path' => $path,
                'url' => asset('storage/' . $path),
                'name' => $request->file('file')->getClientOriginalName(),
                'extension' => $request->file('file')->extension(),
                'size' => Storage::disk('public')->size($path)
            ]))->type('upload')
                ->from($user->organisation)
                ->to($conversation)
                ->send();
        }

        if ($request->filled('message')) {
            $message[] = Chat::message($request->get('message'))->from($user->organisation)
                ->to($conversation)
                ->send();
        }

        Chat::conversation($conversation)->setParticipant($user->organisation)->readAll();

        return response()->json($message);
    }

    public function destroyMessage(Request $request, Message $message)
    {
        Chat::message($message)->setParticipant($request->user()->organisation)
            ->delete();

        return $this->returnResponse([], 200, __('resources.deleted'));
    }

    private function conversationMapper($item, $isConversation = false)
    {
        $conversation = $isConversation ? $item : $item->conversation;

        $users = $conversation->getParticipants();

        $filtered = $users->filter(function ($item) {
            if ($item && isset($item['id']))
                return $item['id'] !== auth()->user()->id;
            else
                return false;
        });

        $names = $filtered->pluck('name')->toArray();

        $ids = $filtered->pluck('id')->toArray();

        $item['is_group'] = count($names) > 1;

        $names = implode(', ', $names);

        $item['names'] = $names;
        $item['ids'] = $ids;

        if (isset($conversation['data']['name'])) {
            $item['name'] = $conversation['data']['name'];
        } else {
            $item['name'] = $names;
        }

        $item['unread_messages'] = Chat::conversation($conversation)->setParticipant(auth()->user())
            ->unreadCount();

        unset($item['participants']);

        return $item;
    }
}
