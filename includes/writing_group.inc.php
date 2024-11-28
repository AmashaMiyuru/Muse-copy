<?php
session_start();
require_once '../classes/writingGroup.classes.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $communityId = $_POST['community_id'];
    $groupName = $_POST['group_name'];

    if (!empty($communityId) && !empty($groupName)) {
        $writingGroupsObj = new WritingGroups();
        if ($writingGroupsObj->createWritingGroup($communityId, $groupName)) {
            header("Location: ../php/writing_groups.php?community_id=$communityId&success=groupcreated");
        } else {
            header("Location: ../php/writing_groups.php?community_id=$communityId&error=creationfailed");
        }
    } else {
        header("Location: ../php/writing_groups.php?community_id=$communityId&error=invalidinput");
    }
    exit();
}
