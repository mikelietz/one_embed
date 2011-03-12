<?php

class One_Embed extends Plugin
{
	public function set_priorities()
	{
		return array(
			'filter_post_content_out' => 11
			);
	}

	public function configure()
	{
		$ui = new FormUI( "one_embed" );

		// Add a text control for the prefix to the subject field
		$embed_code = $ui->append( 'textarea', 'embed_code', 'option:one_embed__embed_code', _t( "Embed code: ", "one_embed" ) );
		$embed_code->add_validator( 'validate_required' );
		$embed_code->raw = true;

		$ui->append( 'submit', 'save', _t( "Save", "one_embed" ) );
		return $ui;
	}

	public function filter_post_content_out( $content )
	{
		$embed_code = '';
		if(  User::identify()->loggedin ) {
			$embed_code = _t( '<a href="%s">Edit this</a> ', array( URL::get( 'admin' , 'page=plugins&configure=' . $this->plugin_id . '&configaction=_configure' ) . '#plugin_' . $this->plugin_id ), "one_embed" );
		}
		$embed_code .= Options::get( 'one_embed__embed_code', '' );

		$content = str_ireplace( '<!-- embed -->', $embed_code, $content );
		return $content;
	}
}

?>
