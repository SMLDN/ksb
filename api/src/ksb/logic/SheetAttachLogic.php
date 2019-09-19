<?php

namespace Ksb\Logic;

use Ksb\Model\SheetAttach;
use Ksb\Model\User;

class SheetAttachLogic
{

    /**
     * Upload File
     *
     * @param [type] $files
     * @param User $user
     * @param Sheet $sheet
     * @return void
     */
    public function uploadFile($file, User $user)
    {
        if ($file->getClientFilename() == null) {
            return null;
        }
        $sheetAttach = new SheetAttach();
        $sheetAttach->attachContent = $file;
        $sheetAttach->userId = $user->id;
        $sheetAttach->attachName = $file->getClientFilename();
        $sheetAttach->save();
        return $sheetAttach;

    }

}
