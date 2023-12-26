<?php

namespace App\Http\Controllers;

use App\Models\Support;
use Illuminate\Http\Request;

class ContactsController extends Controller
{
  /**
   * Shows the card for a given id.
   *
   * @return \Illuminate\Contracts\View\View
   */
  public function show()
  {
    return view('pages.contact_us');
  }

  public function create(Request $request)
  {
    $request->validate([
      'supp_name' => 'string',
      'supp_email' => 'required|email',
      'supp_subject' => 'required|string',
      'supp_content' => 'required|string'
    ]);

    $support = new Support();
    $support->name = empty($request->input('supp_name')) ? "Anonymous" : $request->input('supp_name');
    $support->email = $request->input('supp_email');
    $support->subject = $request->input('supp_subject');
    $support->content = $request->input('supp_content');
    $support->save();

    return $support;
  }
}