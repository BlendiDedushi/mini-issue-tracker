<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case ProjectOwner = 'project_owner';
    case Member = 'member';
}
