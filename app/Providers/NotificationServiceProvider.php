<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Notification;

class NotificationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public static function new($data)
    {
        if(!isset($data->icon) || is_null($data())){
            switch ($data->type) {
                case 'info':
                    $data->icon="fa fa-info";
                    break;
                case 'success':
                    $data->icon="fa fa-check";
                    break;
                case 'danger':
                    $data->icon="fa fa-times";
                    break;
                case 'warning':
                    $data->icon="fa fa-exclamation";
                    break;
                default:
                    $data->icon="fab fa-laravel";
                    break;
            }
        }

        $notification=new Notification(array(
            "text"=>$data->text,
            "type"=>$data->type,
            "icon"=>$data->icon,
            "user_id"=>$data->user_id,
        ));
        if (isset($data->url)) {
            $notification->url=$data->url;
        }

        return $notification->save();
    }

    public static function read($id)
    {
        $notification=Notification::find($id);
        $notification->readed=true;
        return $notification->save();
    }

    public static function readAll($user_id)
    {
        return Notification::where("user_id",$user_id)->update(['readed'=>true]);
    }
}
