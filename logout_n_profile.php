<?php
echo '<div class="row">';
echo '<form method="post">'; ///_POST['logout'] is used in session_management
echo '	<input type="submit" name="logout" value="Log Out"/> ';
echo '</form>';

if ($title == "customer")
{ //update the profile
    echo '<p>';
    echo '<a href="customers_update.php" class="btn btn-success">Update your customer profile</a>';
    echo '</p>';
}
if ($title == "employee")
{
    echo '<p>';
    echo '<a href="employees_update.php" class="btn btn-success">Update your employee profile</a>';
    echo '</p>';
}
echo '</div>';
?>
