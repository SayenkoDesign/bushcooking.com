<?php

if (!defined('ABSPATH')) exit;

class gdrts_rich_snippets_snippet_microdata {
    public $method = '';
    public $itemscope = '';

    public $item;

    public $snippet = array();

    function __construct($method, $itemscope, $item) {
        $this->method = $method;
        $this->itemscope = $itemscope;
        $this->item = $item;
    }

    public function snippet() {
        if ($this->method == 'stars-review') {
            $this->_review();
        } else {
            $this->_rating();
        }

        if (isset($this->snippet['root'])) {
            echo $this->_render_span($this->snippet['root']);
        }
    }

    private function _rating() {
        $rating = array();

        if ($this->method == 'stars-rating' && gdrts_is_method_valid('stars-rating')) {
            $rating = gdrtsm_stars_rating()->rating($this->item);
        } else if ($this->method == 'thumbs-rating' && gdrts_is_method_valid('thumbs-rating')) {
            $rating = gdrtsm_thumbs_rating()->rating($this->item);
        }

        if (!empty($rating)) {
            $this->snippet['root'] = array(
                'tag' => 'span', 
                'itemscope' => true, 
                'itemtype' => 'http://schema.org/'.$this->itemscope,
                'items' => array(
                    'name' => array('tag' => 'meta', 'itemprop' => 'name', 'content' => $this->item->title()),
                    'url' => array('tag' => 'meta', 'itemprop' => 'url', 'content' => $this->item->url()),
                    'rating' => array('tag' => 'span', 'itemscope' => true, 'itemprop' => 'aggregateRating', 'itemtype' => 'http://schema.org/AggregateRating', 'items' => array(
                        'value' => array('tag' => 'meta', 'itemprop' => 'ratingValue', 'content' => $rating['value']),
                        'best' => array('tag' => 'meta', 'itemprop' => 'bestRating', 'content' => $rating['best']),
                        'count' => array('tag' => 'meta', 'itemprop' => 'ratingCount', 'content' => $rating['count'])
                    ))
                )
            );
        }
    }

    private function _review() {
        $rating = gdrtsm_stars_review()->rating($this->item);

        if (!empty($rating)) {
            $this->snippet['root'] = array(
                'tag' => 'span', 
                'itemscope' => true, 
                'itemtype' => 'http://schema.org/Review',
                'items' => array(
                    'item' => array('tag' => 'span', 'itemscope' => true, 'itemprop' => 'itemReviewed', 'itemtype' => 'http://schema.org/'.$this->itemscope, 'items' => array(
                        'name' => array('tag' => 'meta', 'itemprop' => 'name', 'content' => $this->item->title()),
                        'url' => array('tag' => 'meta', 'itemprop' => 'url', 'content' => $this->item->url())
                    )),
                    'rating' => array('tag' => 'span', 'itemscope' => true, 'itemprop' => 'reviewRating', 'itemtype' => 'http://schema.org/Rating', 'items' => array(
                        'value' => array('tag' => 'meta', 'itemprop' => 'ratingValue', 'content' => $rating['value']),
                        'best' => array('tag' => 'meta', 'itemprop' => 'bestRating', 'content' => $rating['best'])
                    )),
                    'author' => array('tag' => 'span', 'itemscope' => true, 'itemprop' => 'author', 'itemtype' => 'http://schema.org/Person', 'items' => array(
                        'name' => array('tag' => 'meta', 'itemprop' => 'name', 'content' => get_the_author_meta('display_name', $this->item->data->post_author)),
                        'url' => array('tag' => 'meta', 'itemprop' => 'url', 'content' => get_author_posts_url($this->item->data->post_author))
                    )),
                    'publisher' => array('tag' => 'span', 'itemscope' => true, 'itemprop' => 'publisher', 'itemtype' => 'http://schema.org/Organization', 'items' => array(
                        'name' => array('tag' => 'meta', 'itemprop' => 'name', 'content' => get_bloginfo('blogname')),
                        'url' => array('tag' => 'meta', 'itemprop' => 'url', 'content' => site_url())
                    ))
                )
            );
        }
    }

    private function _render_meta($data) {
        return '<meta itemprop="'.$data['itemprop'].'" content="'.$data['content'].'" />';
    }

    private function _render_span($data) {
        $out = '<span itemscope itemtype="'.$data['itemtype'].'"';

        if (isset($data['itemprop'])) {
            $out.= ' itemprop="'.$data['itemprop'].'"';
        }

        $out.= '>';

        foreach ($data['items'] as $item) {
            if ($item['tag'] == 'span') {
                $out.= $this->_render_span($item);
            } else {
                $out.= $this->_render_meta($item);
            }
        }

        $out.= '</span>';

        return $out;
    }
}
