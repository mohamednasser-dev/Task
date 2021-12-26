<?php

function upload($file, $dir)
{
    $image = time() . uniqid() . '.' . $file->getClientOriginalExtension();
    $file->move('public/uploads' . '/' . $dir, $image);
    return $image;
}
