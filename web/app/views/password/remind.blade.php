<form action="{{ action('RemindersController@postRemind') }}" method="POST">
    <input type="email" name="mail">
    <input type="submit" value="Send Reminder">
</form>