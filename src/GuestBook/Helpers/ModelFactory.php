<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 14.08.2015
 * Time: 07:38
 */
namespace GuestBook\Helpers;
use GuestBook\Models\GuestBookFileModel;

class ModelFactory {
    public static function getGuestBookModel(){
        return new GuestBookFileModel();
    }
}