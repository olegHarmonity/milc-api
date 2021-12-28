<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Notification;
use App\Util\NotificationCategories;

class NotificationFactory extends Factory
{

    public function definition()
    {
        return [
            'title' => $this->faker->word(),
            'message' => $this->faker->text(),
            'category' => array_random(NotificationCategories::getCategories()),
            'organisation_id' => array_random([
                null,
                1,
                2,
                3,
                4,
                5
            ]),
            'sender_id' => array_random([
                null,
                1,
                2,
                3,
                4,
                5
            ]),
            'is_for_admin' => $this->faker->boolean()
        ];
    }

    public static function createNotification(string $title, string $message, string $category, int $organisationId = null, int $senderId = null, bool $isForAdmin = false)
    {
        $notification = new Notification();

        $notification->title = $title;
        $notification->message = $message;
        $notification->category = $category;
        $notification->organisation_id = $organisationId;
        $notification->sender_id = $senderId;
        $notification->is_for_admin = $isForAdmin;

        $notification->save();
        return $notification;
    }
}
