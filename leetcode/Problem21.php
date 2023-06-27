<?php


class ListNode {
    public $val = 0;
    public $next = null;
    function __construct($val = 0, $next = null) {
        $this->val = $val;
        $this->next = $next;
    }
}


function mergeTwoLists(ListNode $list1, ListNode $list2) {
    if(!$list1 && !$list2) {
        return null;
    }
    if(!$list1) {
        return $list2;
    }
    if(!$list2) {
        return $list1;
    }
    $listOnePointer = $list1;
    $listTwoPointer = $list2;
    $mergedList = null;
    $mergedPointer = null;
    while($listOnePointer && $listTwoPointer) {
        $newNode = null;
        if ($listOnePointer->val < $listTwoPointer->val) {
            $newNode = new ListNode($listOnePointer->val);
            $listOnePointer = $listOnePointer->next;
        } else {
            $newNode = new ListNode($listTwoPointer->val);
            $listTwoPointer = $listTwoPointer->next;
        }
        if($mergedList === null) {
            $mergedList = $newNode;
            $mergedPointer = $newNode;
        } else {
            $mergedPointer->next = $newNode;
            $mergedPointer = $newNode;
        }
    }
    if($listOnePointer) {
        while($listOnePointer) {
            $newNode = new ListNode($listOnePointer->val);
            $mergedPointer->next = $newNode;
            $mergedPointer = $newNode;
            $listOnePointer = $listOnePointer->next;
        }
    }
    if($listTwoPointer) {
        while($listTwoPointer) {
            $newNode = new ListNode($listTwoPointer->val);
            $mergedPointer->next = $newNode;
            $mergedPointer = $newNode;
            $listTwoPointer = $listTwoPointer->next;
        }
    }

    return $mergedList;
}