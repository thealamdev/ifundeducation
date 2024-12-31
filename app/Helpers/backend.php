<?php

use App\Models\Comment;
use App\Models\ContactMessage;
use App\Models\Donate;
use App\Models\FundraiserUpdateMessage;
use App\Models\Payout;

function unreadCommentsCount() {
    $count = Comment::where('admin_view', 0)->count();
    return $count;
}

function unread10Comments() {
    $commets = Comment::where('admin_view', 0)->orderBy('id', 'desc')->take(10)->get();
    return $commets;
}
function unreadUpdateMessageCount() {
    $count = FundraiserUpdateMessage::where('admin_view', 0)->count();
    return $count;
}

function unread10updateMessage() {
    $UpdateMessage = FundraiserUpdateMessage::where('admin_view', 0)->orderBy('id', 'desc')->take(10)->get();
    return $UpdateMessage;
}
function unreadContactMessageCount() {
    $contact = ContactMessage::where('status', 'unread')->count();
    return $contact;
}

function unreadDotationCount() {
    $count = Donate::where('admin_view', 0)->count();
    return $count;
}
function unreadPayoutCount() {
    $count = Payout::where('admin_view', 0)->count();
    return $count;
}