# WP Cavalry
An API of helper functions that replace core WordPress functions by using versions that cache the results.
Based on the wordpress.com VIP caching functions.
## Installation
1. Download the latest relaease.
2. unzip the file.
3. upload the folder to the plugins directory.
---
### cached_attachment_url_to_postid()
#### Description
Returns the post ID from the attachment URL. Replaces [attachment_url_to_postid()](https://developer.wordpress.org/reference/functions/attachment_url_to_postid/)
#### Usage
```
<?php cached_attachment_url_to_postid( $url ); ?>
```
#### Parameters
**$url**
(string) (Required) The URL to resolve.
---
### cached_count_user_posts()
#### Description
Returns the number of posts by user. Replaces [count_user_posts()](https://developer.wordpress.org/reference/functions/count_user_posts/)
#### Usage
```
<?php cached_count_user_posts( $user_id, $post_type ); ?>
```
#### Parameters
**$user_id**
(integer) (Required) The ID of the user to count posts for.
**$post_type**
(string) (Optional) Post type to count the number of posts for.
default: 'post'
---
### cached_get_adjacent_post()
#### Description
Can either be next or previous post. Replaces [get_adjacent_post()](https://developer.wordpress.org/reference/functions/get_adjacent_post/)
#### Usage
```
<?php cached_get_adjacent_post( $in_same_term, $excluded_terms, $previous, $taxonomy ); ?>
```
#### Parameters
**$in_same_term**
(bool) (Optional) Whether post should be in a same taxonomy term.
Default value: false
**$excluded_terms**
(array|string) (Optional) Array or comma-separated list of excluded term IDs.
Default value: ''
**$previous**
(bool) (Optional) Whether to retrieve previous post. Default true
Default value: true
**$taxonomy**
(string) (Optional) Taxonomy, if $in_same_term is true.
Default value: 'category'
---
### cached_get_category_by_slug()
#### Description
Retrieve category object by category slug. Replaces [get_category_by_slug()](https://developer.wordpress.org/reference/functions/get_category_by_slug/)
#### Usage
```
<?php cached_get_category_by_slug( $slug ); ?>
```
#### Parameters
**$slug**
(string) (Required) The category slug.
---
### cached_get_nav_menu_object()
#### Description
Returns nav menu object when given a menu id, slug, or name. Replaces [get_nav_menu_object()](https://developer.wordpress.org/reference/functions/wp_get_nav_menu_object/)
#### Usage
```
<?php cached_get_nav_menu_object( $menu ); ?>
```
#### Parameters
**$menu**
(int|string|WP_Term) (Required) Menu ID, slug, or name - or the menu object.
---
### cached_get_page_by_path()
#### Description
Retrieves a page or other post object given its path. Replaces [get_page_by_path()](https://developer.wordpress.org/reference/functions/get_page_by_path/)
#### Usage
```
<?php cached_get_page_by_path( $page_path, $output, $post_type ); ?>
```
#### Parameters
**$page_path**
(string) (Required) Page path.
**$output**
(string) (Optional) The required return type. One of OBJECT, ARRAY_A, or ARRAY_N, which correspond to a WP_Post object, an associative array, or a numeric array, respectively.
Default value: OBJECT
**$post_type**
(string|array) (Optional) Post type or array of post types.
Default value: 'page'
---
### cached_get_page_by_title()
#### Description
Retrieves a post given its title. Replaces [get_page_by_title()](https://developer.wordpress.org/reference/functions/get_page_by_title/)
#### Usage
```
<?php cached_get_page_by_title( $title, $output, $post_type ); ?>
```
#### Parameters
**$page_title**
(string) (Required) Page title
**$output**
(string) (Optional) The required return type. One of OBJECT, ARRAY_A, or ARRAY_N, which correspond to a WP_Post object, an associative array, or a numeric array, respectively.
Default value: OBJECT
**$post_type**
(string|array) (Optional) Post type or array of post types.
Default value: 'page'
---
### cached_get_term_by()
#### Description
Get all Term data from database by Term field and data. Replaces [get_term_by()](https://developer.wordpress.org/reference/functions/get_term_by/)
#### Usage
```
<?php cached_get_term_by( $field, $value, $taxonomy, $output, $filter ); ?>
```
#### Parameters
**$field**
(string) (Required) Either 'slug', 'name', 'id' (term_id), or 'term_taxonomy_id'
**$value**
(string|int) (Required) Search for this term value
**$taxonomy**
(string) (Optional) Taxonomy name. Optional, if $field is 'term_taxonomy_id'.
Default value: ''
**$output**
(string) (Optional) The required return type. One of OBJECT, ARRAY_A, or ARRAY_N, which correspond to a WP_Term object, an associative array, or a numeric array, respectively.
Default value: OBJECT
**$filter**
(string) (Optional) default is raw or no WordPress defined filter will applied.
Default value: 'raw'
---
### cached_get_term_link()
#### Description
Generate a permalink for a taxonomy term archive. Replaces [get_term_link()](https://developer.wordpress.org/reference/functions/get_term_link/)
#### Usage
```
<?php cached_get_term_link( $term, $taxonomy ); ?>
```
#### Parameters
**$term**
(object|int|string) (Required) The term object, ID, or slug whose link will be retrieved.
**$taxonomy**
(string) (Optional) Taxonomy.
Default value: ''
---
### cached_term_exists()
#### Description
Check if Term exists. Replaces [term_exists()](https://developer.wordpress.org/reference/functions/term_exists/)
#### Usage
```
<?php cached_term_exists( $term, $taxonomy, $parent ); ?>
```
#### Parameters
**$term**
(int|string) (Required) The term to check. Accepts term ID, slug, or name.
**$taxonomy**
(string) (Optional) The taxonomy name to use
Default value: ''
**$parent**
(int) (Optional) ID of parent term under which to confine the exists search.
Default value: null
---
### cached_url_to_postid()
#### Description
Examine a URL and try to determine the post ID it represents. Replaces [url_to_postid()](https://developer.wordpress.org/reference/functions/url_to_postid/)
#### Usage
```
<?php cached_url_to_postid( $url ); ?>
```
#### Parameters
**$url**
(string) (Required) Permalink to check.
---
### cached_wp_query()
#### Description
Caches custom WP_Query results. See [WP_Query](https://developer.wordpress.org/reference/classes/wp_query/)
#### Usage
```
<?php cached_wp_query( $name, $query_args = array() ); ?>
```
#### Parameters
**$name**
(string) (Required) The name to assign the queried object.
**$url**
(array) (Required) The WP_Query arguments.
---
