<?php
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Category
 *
 * @property int $id
 * @property string $category_name
 * @property string $category_slug
 * @property int $count
 * @property int $category_parent
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Post[] $posts
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereCategoryName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereCategoryParent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereCategorySlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereUpdatedAt($value)
 */
	class Category extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Comment
 *
 * @property int $id
 * @property int $post_id 被评论文章ID
 * @property string $comment_author 评论人
 * @property string $comment_author_email 评论人邮箱
 * @property string $comment_author_ip 评论人IP地址
 * @property string $comment_content 评论内容
 * @property string $comment_content_filter 评论内容过滤
 * @property int $comment_parent 被回复评论ID
 * @property int|null $user_id 注册用户ID
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Post $post
 * @property-read \App\Models\User|null $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Comment onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment whereCommentAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment whereCommentAuthorEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment whereCommentAuthorIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment whereCommentContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment whereCommentContentFilter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment whereCommentParent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Comment withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Comment withoutTrashed()
 */
	class Comment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Option
 *
 * @property int $id
 * @property string $option_name
 * @property string|null $option_value
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Option whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Option whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Option whereOptionName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Option whereOptionValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Option whereUpdatedAt($value)
 */
	class Option extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Permission
 *
 * @property int $id
 * @property string $name
 * @property string|null $display_name
 * @property string|null $description
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role[] $roles
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission whereUpdatedAt($value)
 */
	class Permission extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Post
 *
 * @property int $id
 * @property int $user_id 用户ID
 * @property int $category_id 类别ID
 * @property string $post_title
 * @property string $post_slug 链接
 * @property string $post_content 内容
 * @property string $post_content_filter 内容过滤
 * @property string $post_excerpt 文章摘要
 * @property int $post_status 状态：发布/草稿
 * @property int $comment_status 是否允许评论
 * @property string $post_type 文章类型
 * @property int $comment_count 评论数
 * @property int $view_count 浏览数
 * @property \Carbon\Carbon|null $published_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Category $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $comments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tags
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post currentUser()
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Post onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post page()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post post()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post published()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post search($search, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post searchRestricted($search, $restriction, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereCommentCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereCommentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post wherePostContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post wherePostContentFilter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post wherePostExcerpt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post wherePostSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post wherePostStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post wherePostTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post wherePostType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereViewCount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Post withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Post withoutTrashed()
 */
	class Post extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Role
 *
 * @property int $id
 * @property string $name
 * @property string|null $display_name
 * @property string|null $description
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Permission[] $perms
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereUpdatedAt($value)
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Tag
 *
 * @property int $id
 * @property string $tag_name
 * @property int $count
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Post[] $posts
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereTagName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereUpdatedAt($value)
 */
	class Tag extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $avatar 头像
 * @property string|null $website 个人网站
 * @property string|null $github Github
 * @property string|null $weibo 微博
 * @property string|null $wechat 微信二维码
 * @property string|null $wechatpay 微信支付二维码
 * @property string|null $alipay 支付宝二维码
 * @property string|null $city 城市
 * @property string|null $company 公司
 * @property string|null $introduction 个人简介
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role[] $roles
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereAlipay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereGithub($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereIntroduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereWebsite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereWechat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereWechatpay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereWeibo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User withRole($role)
 */
	class User extends \Eloquent {}
}

