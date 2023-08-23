<h1>Hi, {{ $name }}</h1>
<a href="{{ url("/api/email/verify", ['token' => $token]) }}">Link for verification!</a>
<p>Sending Mail using Lumen.</p>
