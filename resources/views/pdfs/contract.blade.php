<!DOCTYPE html>
<html>
<head>
</head>
<body>
	{{ Illuminate\Mail\Markdown::parse($contract_text) }}
    <br><br>
	{{ Illuminate\Mail\Markdown::parse($contract_text_part_2) }}
    <br><br>
	{{ Illuminate\Mail\Markdown::parse($contract_appendix) }}
</body>
</html>