<?php

class utterances extends Plugin {

	public function init()
	{
		$this->dbFields = array(
			'myUtterancesRepo'=>'',
      'enablePages'=>true,
			'enableStatic'=>true,
			'enableSticky'=>true,
			'utterancesTheme'=>''
		);
	}

	public function form()
	{
		global $L;

		$html  = '<div class="alert alert-primary" role="alert">';
		$html .= $L->get('utterances-installation');
		$html .= '</div>';

		// Add your Utterances GitHub repository

		$html .= '<div>';
		$html .= '<label>'.$L->get('utterances-repository').'</label>';
		$html .= '<input name="myUtterancesRepo" id="jsmyUtterancesRepo" type="text" value="'.$this->getValue('myUtterancesRepo').'">';
		$html .= '<span class="tip">'.$L->get('utterances-tip').'</span>';
		$html .= '</div>';

		// Disable comments on static pages

    $html .= '<div>';
    $html .= '<label>'.$L->get('enable-utterances-on-pages').'</label>';
    $html .= '<select name="enablePages">';
    $html .= '<option value="true" '.($this->getValue('enablePages')===true?'selected':'').'>'.$L->get('enabled').'</option>';
    $html .= '<option value="false" '.($this->getValue('enablePages')===false?'selected':'').'>'.$L->get('disabled').'</option>';
    $html .= '</select>';
		$html .= '</div>';

		// Disable comments on static pages

    $html .= '<div>';
    $html .= '<label>'.$L->get('enable-utterances-on-static-pages').'</label>';
    $html .= '<select name="enableStatic">';
    $html .= '<option value="true" '.($this->getValue('enableStatic')===true?'selected':'').'>'.$L->get('enabled').'</option>';
    $html .= '<option value="false" '.($this->getValue('enableStatic')===false?'selected':'').'>'.$L->get('disabled').'</option>';
    $html .= '</select>';
		$html .= '</div>';

		// Disable comments on sticky posts

    $html .= '<div>';
    $html .= '<label>'.$L->get('enable-utterances-on-sticky-pages').'</label>';
    $html .= '<select name="enableSticky">';
    $html .= '<option value="true" '.($this->getValue('enableSticky')===true?'selected':'').'>'.$L->get('enabled').'</option>';
    $html .= '<option value="false" '.($this->getValue('enableSticky')===false?'selected':'').'>'.$L->get('disabled').'</option>';
    $html .= '</select>';
    $html .= '</div>';

		// Chose the GitHub theme for the comments

    $html .= '<div>';
    $html .= '<label>'.$L->get('utterances-select-theme').'</label>';
    $html .= '<select name="utterancesTheme">';
    $html .= '<option value="github-light" '.($this->getValue('utterancesTheme')==='github-light'?'selected':'').'>'.$L->get('GitHub Light').'</option>';
    $html .= '<option value="github-dark" '.($this->getValue('utterancesTheme')==='github-dark'?'selected':'').'>'.$L->get('GitHub Dark').'</option>';
		$html .= '<option value="github-dark-orange" '.($this->getValue('utterancesTheme')==='github-dark-orange'?'selected':'').'>'.$L->get('GitHub Dark Orange').'</option>';
		$html .= '<option value="icy-dark" '.($this->getValue('utterancesTheme')==='icy-dark'?'selected':'').'>'.$L->get('Icy Dark').'</option>';
		$html .= '<option value="dark-blue" '.($this->getValue('utterancesTheme')==='dark-blue'?'selected':'').'>'.$L->get('Dark Blue').'</option>';
		$html .= '<option value="photon-dark" '.($this->getValue('utterancesTheme')==='photon-dark'?'selected':'').'>'.$L->get('Photon Dark').'</option>';
    $html .= '</select>';
    $html .= '</div>';


		return $html;
	}

	public function pageEnd()
	{
		global $url;
		global $WHERE_AM_I;

// Do not shows Utterances on page not found

		if ($url->notFound()) {
			return false;
		}

		if ($WHERE_AM_I==='page') {
			global $page;
			if ($page->published() && $this->getValue('enablePages')) {
				return $this->javascript();
			}
			if ($page->isStatic() && $this->getValue('enableStatic')) {
				return $this->javascript();
			}
			if ($page->sticky() && $this->getValue('enableSticky')) {
				return $this->javascript();
			}
		}

		return false;
	}


// Utterances javascript

	private function javascript()
	{
		global $page;
		$pageURL = $page->permalink();
		$pageID = $page->uuid();
		$myUtterancesRepo = $this->getValue('myUtterancesRepo');
		$utterancesTheme = $this->getValue('utterancesTheme');

$code = <<<EOF

<script src="https://utteranc.es/client.js"
				repo='$myUtterancesRepo'
        issue-term="pathname"
        theme='$utterancesTheme'
        crossorigin="anonymous"
        async>
</script>

EOF;
		return $code;
	}

}
