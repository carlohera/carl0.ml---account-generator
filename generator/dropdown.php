<ul class="dropdown-menu">
<li><a href="https://www.facebook.com/groups/120807335290164/" target="_blank"><i class="fa fa-facebook-official"></i> Facebook Group</a></li>
<li><a href="https://www.facebook.com/Royalty-Cracking-Team-1710813995881675/" target="_blank"><i class="fa fa-facebook-official"></i> Facebook Page</a></li>
<?php $result = mysqli_query($con, "SELECT * FROM `subscriptions` WHERE `username` = '$username'") or die(mysqli_error($con));
if (mysqli_num_rows($result) < 1 && $_SESSION['rank'] == "5") {
	echo '<li><a href="https://m.me/join/AbbwVly6lCeQkcOQ" target="_blank"><i class="fa fa-comments"></i> Group Chat</a></li>';}?>
<li><a href="https://www.youtube.com/channel/UCLgRl326Deu3-RskxksbGCg" target="_blank"><i class="fa fa-youtube-square"></i> Youtube Channel</a></li>
<li><a href="https://twitter.com/RCTRoyalty" target="_blank"><i class="fa fa-twitter-square"></i> Twitter</a></li>
</ul>