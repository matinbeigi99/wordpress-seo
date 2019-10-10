<?php
/**
 * Generator object for the Twitter image.
 *
 * @package Yoast\YoastSEO\Generators
 */

namespace Yoast\WP\Free\Generators;

use Yoast\WP\Free\Context\Meta_Tags_Context;
use Yoast\WP\Free\Helpers\Image_Helper;
use Yoast\WP\Free\Helpers\Twitter\Image_Helper as Twitter_Image_Helper;
use Yoast\WP\Free\Helpers\Url_Helper;
use Yoast\WP\Free\Models\Indexable;
use Yoast\WP\Free\Presentations\Generators\Generator_Interface;
use Yoast\WP\Free\Values\Twitter\Images;

/**
 * Represents the generator class for the Open Graph images.
 */
class Twitter_Image_Generator implements Generator_Interface {

	/**
	 * @var Image_Helper
	 */
	protected $image;

	/**
	 * @var Url_Helper
	 */
	protected $url;

	/**
	 * @var Twitter_Image_Helper
	 */
	protected $twitter_image;

	/**
	 * Images constructor.
	 *
	 * @codeCoverageIgnore
	 *
	 * @param Image_Helper $image The image helper.
	 * @param Url_Helper   $url   The url helper.
	 */
	public function __construct( Image_Helper $image, Url_Helper $url, Twitter_Image_Helper $twitter_image ) {
		$this->image         = $image;
		$this->url           = $url;
		$this->twitter_image = $twitter_image;
	}

	/**
	 * Retrieves the images for an indexable.
	 *
	 * @param Meta_Tags_Context $context The context.
	 *
	 * @return array The images.
	 */
	public function generate( Meta_Tags_Context $context ) {
		$image_container = $this->get_image_container();

		$this->add_from_indexable( $context->indexable, $image_container );

		return $image_container->get_images();
	}

	/**
	 * Adds an image based on the given indexable.
	 *
	 * @param Indexable $indexable       The indexable.
	 * @param Images    $image_container The image container.
	 */
	protected function add_from_indexable( Indexable $indexable, Images $image_container ) {
		if ( $indexable->twitter_image_id ) {
			$image_container->add_image_by_id( $indexable->twitter_image_id );

			return;
		}

		if ( $indexable->twitter_image ) {
			$image_container->add_image_by_url( $indexable->twitter_image );
		}
	}

	/**
	 * Retrieves an instance of the image container.
	 *
	 * @codeCoverageIgnore
	 *
	 * @return Images The image container.
	 */
	protected function get_image_container() {
		$image_container = new Images( $this->image, $this->url );
		$image_container->set_helpers( $this->twitter_image );

		return $image_container;
	}
}
