<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteContent extends Model
{
    use HasFactory;

    protected $table = 'site_content';

    protected $fillable = [
        'type',
        'contentType',
        'pagetitle',
        'longtitle',
        'description',
        'alias',
        'link_attributes',
        'published',
        'pub_date',
        'unpub_date',
        'parent',
        'isfolder',
        'introtext',
        'content',
        'richtext',
        'template',
        'menuindex',
        'searchable',
        'cacheable',
        'createdby',
        'createdon',
        'editedby',
        'editedon',
        'deleted',
        'deletedon',
        'deletedby',
        'publishedon',
        'publishedby',
        'menutitle',
        'hide_from_tree',
        'privateweb',
        'privatemgr',
        'content_dispo',
        'hidemenu',
        'class_key',
        'context_key',
        'content_type',
        'uri',
        'uri_override',
        'hide_children_in_tree',
        'show_in_tree',
        'properties',
        'alias_visible',
        'haskeywords',
        'hasmetatags',
    ];
}
