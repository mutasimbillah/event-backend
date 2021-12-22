<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\NotificationRequest;
use App\Models\EventNotification;
use Illuminate\Http\Request;

class NotificationController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return $this->success(EventNotification::all(), "All Notifications");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NotificationRequest $request)
    {
        //
        $notification = EventNotification::create($request->all());
        return $this->success($notification, "Notification Created");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $notification = EventNotification::where('id', $id)->first();
        if ($notification) {
            return $this->success($notification, "Single Notification with Details");
        } else {
            return $this->failed(null, "No Notification Found with the id");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
