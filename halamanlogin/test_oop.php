<?php
    include_once("classes.php");

    $user1 = new User();
    $user1->set_user(1, 'John Doe', ' John@Mail.Com ', 'password123');

    $role1 = new Role(); $role1->set_role(1, 'Admin', true);
    $role2 = new Role(); $role2->set_role(2, 'Dokter', false);

    $user1->set_role($role1);
    $user1->set_role($role2);

    print_r($user1->get_user());
    // echo $user1->email; -> Fatal error: Cannot access private property User::$email
?>