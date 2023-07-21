<?php

class IoUtils
{
    public static function isDirectoryEmpty($directoryPath): bool {
        return count(glob($directoryPath . '/*')) === 0;
    }
}