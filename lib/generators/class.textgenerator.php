<?php
    /*
    Copyrights: Deux Huit Huit 2015
    LICENCE: MIT, http://deuxhuithuit.mit-license.org/
    */
    
    if(!defined("__IN_SYMPHONY__")) die("<h2>Error</h2><p>You cannot directly access this file</p>");
    
    /**
     *
     * @author Deux Huit Huit
     * https://deuxhuithuit.com/
     *
     */
    class TextGenerator
    {
        protected static $defaultOptions = array(
            'max-length' => 0,
            'paragraphs' => 1
        );
        public static function generate($options)
        {
            $value = array();
            $options = array_merge($options, self::$defaultOptions, $options);
            $pcount = count(self::$paragraphs);
            for ($x = 0; $x < General::intval($options['paragraphs']); $x++) {
                $value[] = self::$paragraphs[$x % $pcount];
            }
            $value = implode(PHP_EOL . PHP_EOL, $value);
            $maxLength = General::intval($options['max-length']);
            if ($maxLength > 0 && General::strlen($value) > $maxLength) {
                $value = General::substr($value, 0, $maxLength);
            }
            return $value;
        }
        protected static $paragraphs = array(
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis gravida consectetur orci et sollicitudin. In ac cursus lectus. Integer tempor lorem ac risus convallis, non tristique lectus pharetra. Aliquam sagittis eros id urna mattis dignissim. Nam bibendum et lacus non gravida. Quisque dignissim ipsum vel egestas mollis. Proin augue nisl, elementum at ultricies sit amet, dictum non augue. Interdum et malesuada fames ac ante ipsum primis in faucibus. Praesent nunc metus, vulputate sed varius quis, ultricies scelerisque sapien. Quisque in gravida eros. Vestibulum tincidunt finibus mattis.',
            'Cras porttitor ac erat quis auctor. Nam sapien libero, porttitor vitae lorem rutrum, sollicitudin blandit orci. Sed bibendum ex a semper sagittis. Ut accumsan porttitor lacus, et dictum dolor. Fusce tristique, leo ac interdum rutrum, urna eros molestie metus, non gravida nisl nulla ut magna. Fusce vel orci mi. Curabitur tincidunt sapien eu libero posuere, sit amet luctus tortor ultrices. Praesent eget orci sit amet metus euismod vestibulum. Proin enim est, elementum sit amet tortor eu, blandit bibendum mauris.',
            'Praesent congue dolor a neque tincidunt euismod. Proin eleifend ligula et orci suscipit, a iaculis risus consequat. Donec quis ullamcorper nisl. Duis et libero non diam venenatis viverra. Integer porttitor arcu id nulla commodo, sit amet imperdiet nisi ultricies. In eleifend orci nulla, eget posuere nulla tincidunt sed. Vestibulum ac turpis et erat varius faucibus eget eget dui. Morbi tincidunt arcu eu interdum aliquam. Nulla eget lorem quis ex venenatis lobortis. Curabitur in eros aliquet, pulvinar ex eu, luctus ipsum. Aenean ac neque et diam pulvinar pharetra in non ligula. Suspendisse facilisis feugiat gravida. Donec molestie purus in ipsum tristique porttitor. Vestibulum ultricies venenatis purus, sed dapibus est eleifend quis. Etiam sit amet pellentesque lacus. Proin condimentum risus ac volutpat lobortis.',
            'Mauris pharetra imperdiet lacus. Quisque ultricies rhoncus dolor, eget rutrum enim commodo id. Nulla facilisi. Suspendisse cursus sollicitudin nisl at lacinia. Phasellus in vulputate lorem, id interdum justo. Nunc commodo egestas rutrum. Donec eu velit quis libero condimentum sagittis. Donec non interdum nisi, sit amet faucibus turpis. Duis rutrum lectus a ante sollicitudin finibus. Donec volutpat quam enim, quis vehicula tortor viverra eget. Aenean id odio nec turpis tristique elementum blandit vulputate mauris. Fusce id ultricies quam. Donec sapien nisi, ultricies hendrerit venenatis eget, blandit sit amet ex. Suspendisse a nibh dapibus dui hendrerit eleifend aliquet in nulla. Nullam id viverra arcu. Aliquam eleifend fringilla risus a congue.',
            'Nam in fermentum augue. Maecenas pellentesque, nulla eu sollicitudin vehicula, tellus quam tincidunt nibh, non sodales justo erat a ex. Nullam non tellus tincidunt mauris fringilla mollis. Integer tempus malesuada magna in scelerisque. Proin eget interdum purus. Fusce eu rutrum elit. Quisque eu posuere nibh, id placerat mi. Donec nec tortor sem. Nulla facilisi. Pellentesque rhoncus velit ac mi tempus luctus. Pellentesque eu metus luctus risus pretium venenatis sed faucibus felis. Praesent rhoncus commodo magna nec malesuada. Phasellus maximus molestie urna, vitae ultrices purus dignissim sit amet. Sed feugiat venenatis enim quis vulputate.',
            'Aenean luctus tristique risus vel scelerisque. Sed id nisl eu neque ornare dictum. Curabitur dui nunc, feugiat sit amet tincidunt ac, aliquet at lorem. Suspendisse potenti. Nam dictum fermentum sodales. Curabitur sit amet nibh a mauris vehicula pellentesque. Nunc efficitur, diam sed aliquet blandit, velit dolor efficitur diam, eu tristique lacus magna a risus. Sed nec mollis justo, eu dapibus arcu. Proin tincidunt egestas est, ac sagittis urna aliquet id. Mauris a lectus metus. Proin rhoncus imperdiet purus, id ullamcorper tortor tempus at.',
            'Ut ligula odio, condimentum vel fringilla non, accumsan non risus. Etiam quis suscipit felis. Cras rutrum pulvinar orci, sed aliquam ipsum placerat id. Nullam scelerisque ultricies massa, in pulvinar est luctus laoreet. Pellentesque vel justo a metus viverra mollis vitae nec quam. Curabitur congue euismod eros. Pellentesque luctus laoreet nunc, ac vestibulum tortor auctor vitae. Proin libero ex, pretium ac molestie maximus, blandit sed leo. Aliquam pulvinar sem quis finibus mollis. Integer venenatis sollicitudin erat quis rutrum. Integer pretium luctus nunc in consectetur. Proin aliquet lobortis commodo. Ut ultricies diam vitae aliquet sodales.',
            'Cras molestie consequat ipsum nec dapibus. Phasellus consectetur varius nibh. Fusce eget quam lectus. Fusce sit amet faucibus est, in sagittis orci. Morbi eu enim sed tortor blandit bibendum ut at diam. Nunc sagittis mi quis sem varius fringilla. Donec vitae enim vitae nunc condimentum tincidunt. Morbi condimentum est tincidunt, maximus nisi lacinia, laoreet turpis. Ut condimentum tellus ac pretium viverra. Nam sed augue sagittis, laoreet libero sit amet, tristique metus. Donec condimentum elit vitae vestibulum tristique. Quisque ipsum dolor, pellentesque a magna quis, feugiat interdum velit. Maecenas condimentum arcu et justo mattis volutpat. Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'Vivamus scelerisque nulla vitae vulputate rhoncus. Aliquam fringilla sed nisi eget rhoncus. Vivamus at tortor eu tortor ultricies tincidunt. Sed efficitur ex nibh, nec placerat purus bibendum vitae. Pellentesque venenatis finibus magna nec posuere. Nulla nunc lacus, posuere ut tincidunt sed, placerat et nisl. Donec ultrices purus ultricies, congue turpis sit amet, commodo tellus. Curabitur aliquam id tellus in viverra.',
            'Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vivamus consequat maximus purus, ut consectetur eros porttitor id. Phasellus porta tortor dui, a vestibulum elit scelerisque nec. Donec libero mi, iaculis non eros a, sollicitudin pellentesque dolor. Duis et velit a ipsum sodales scelerisque. Quisque ut dolor lacinia, ultrices ipsum vitae, gravida libero. Proin lacinia, ligula at varius finibus, ipsum elit gravida ex, in scelerisque libero dui sagittis lorem.',
        );
    }