<h3>
Dear {{ $data['firstname']. ' '.$data['surname'] }} <br> This a confirmation email for your registiration please press 
<a href='{{ url("") }}/users/confirmRegistiration/email/{{ $data["email"] }}/confirm_token/{{ $data["confirmation_token"] }}'>here</a> to complete the registiration process.
</h3>