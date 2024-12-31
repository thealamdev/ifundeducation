<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CommonPage;
use App\Models\ContactMessage;
use App\Models\ContactPage;
use App\Models\Faq;
use App\Models\FaqPage;
use App\Models\FundraiserPost;
use App\Models\HomePageBanner;
use App\Models\IconTextBox2Col;
use App\Models\IconTextBox;
use App\Models\Wishlist;
use App\Rules\ReCaptcha;
use Illuminate\Http\Request;

class FrontController extends Controller {
    public function index() {

        $fundRaiserPosts = FundraiserPost::with([
            'fundraisercategory',
            'donates' => function ($q) {
                $q->select('id', 'amount', 'net_balance', 'fundraiser_post_id');
            },
            'user.academic_profile.university',
        ])->where('status', "running")->orderBy('id', 'desc')->get();

        $wishlists_id = Wishlist::where('user_id', auth()->user()->id ?? '')->pluck('fundraiser_post_id')->all();

        $homePageBanner    = HomePageBanner::orderBy('id', 'desc')->first();
        $home3ColumnBlocks = IconTextBox::where('status', 1)->orderBy('id', 'asc')->get();
        $home2ColumnBlocks = IconTextBox2Col::orderBy('id', 'asc')->get();

        return view('frontend.index', compact('fundRaiserPosts', 'wishlists_id', 'homePageBanner', 'home3ColumnBlocks', 'home2ColumnBlocks'));
    }

    public function CommonPage($slug) {
        $commonPage = CommonPage::where('slug', $slug)->firstOrFail();
        return view('frontend.common_page', compact('commonPage'));
    }

    public function fundraiser() {
        $fundRaiserPosts = FundraiserPost::with([
            'fundraisercategory',
            'donates' => function ($q) {
                $q->select('id', 'amount', 'net_balance', 'fundraiser_post_id');
            },
            'user.academic_profile.university',
        ])->where('status', "running")->orderBy('id', 'desc')->paginate(21);
        $wishlists_id = Wishlist::where('user_id', auth()->user()->id ?? '')->pluck('fundraiser_post_id')->all();
        return view('frontend.fundraiser', compact('fundRaiserPosts', 'wishlists_id'));
    }

    public function contact() {
        $contactPage = ContactPage::first();
        return view('frontend.contact', compact('contactPage'));
    }

    public function faq() {
        $faqPage = FaqPage::first();
        $faqs    = Faq::orderBy('id', 'asc')->get();
        return view('frontend.faq', compact('faqPage', 'faqs'));
    }

    /* Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function contactStore(Request $request) {
        // dd($request->all());
        $request->validate([
            "your_name"            => 'required|max:255',
            "your_email"           => 'required|max:255',
            'g-recaptcha-response' => ['required', new ReCaptcha],
        ]);

        $insert = ContactMessage::create([
            'your_name'  => $request->your_name,
            'your_email' => $request->your_email,
            'subject'    => $request->subject,
            'message'    => $request->message,
            'status'     => 'unread',
        ]);

        if ($insert) {
            return back()->with('success', 'Your Message Sent Successful!');
        } else {
            return back()->with('error', 'Your Message Sent Error!');
        }

        // return redirect()->back()->with(['success' => 'Contact Form Submit Successfully']);
    }

    public function fundraiserSearch(Request $request) {
        $fundRaiserPosts = FundraiserPost::with([
            'fundraisercategories',
            'donates' => function ($q) {
                $q->select('id', 'amount', 'fundraiser_post_id');
            },
            'user.academic_profile.university',
        ])->where('status', "running")
            ->where('title', 'LIKE', "%$request->q%")
            ->orderBy('id', 'desc')->paginate(21);
        $wishlists_id = Wishlist::where('user_id', auth()->user()->id ?? '')->pluck('fundraiser_post_id')->all();
        return view('frontend.fundraiser', compact('fundRaiserPosts', 'wishlists_id'));
    }

}
