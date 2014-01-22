<?php

class Popup {

	public static $arrowsDir = '/img/';
	public static $leftArrow = 'leftarrow.png';
	public static $rightArrow = 'rightarrow.png';

	protected static $popupHTML = <<<HTML
<div id="info">
	<div id="leftArrow">
		<img src="%s" />
	</div>
	<div id="infoContents">
		<div id="infoName">
			Name
		</div>
		<br />

		<div id="infoDescription">
			Description
		</div>
		<br />

		<div id="infoExtra">
			Extra
		</div>
	</div>
	<div id="rightArrow">
		<img src="%s" />
	</div>
</div>
HTML;

	// Parameters: popupElementClass
	protected static $popupJS = <<<JS
<script>
$(document).ready(function() {
	info=($('#info'));
	lA=($('#leftArrow'));
	rA=($('#rightArrow'));
	infoName=($('#infoName'));
	infoDescription=($('#infoDescription'));
	infoExtra=($('#infoExtra'));
	var left, top, offsetLeft, offsetTop;
	var width, height, docWidth;
	arrowWidth=24;
	width=335 + arrowWidth; //Only one arrow is shown at a time
	height=150;


	$('.%s').each(function() {
		$(this).mouseenter(function() {
			docWidth=$(window).width();
			offsetLeft=$(this).offset().left;
			offsetTop=$(this).offset().top;

			var blockWidth = $(this).outerWidth(false);
			var blockHeight = $(this).outerHeight(false);

			top=offsetTop + blockHeight/2 - height/2;
			//the scrollLeft is necessary, offsetLeft - scrollLeft gives window coordinates, so the snippet is positioned correctly
			if(offsetLeft - $(window).scrollLeft() + blockWidth + width > docWidth) 
			{
				left=offsetLeft - width;
				lA.hide();
				rA.show();
			}
			else
			{
				left=offsetLeft + blockWidth;
				lA.show();
				rA.hide();
			}

			info.css({ left: left + 'px', top: top + 'px', display:'block'});
			infoName.html($(this).data("name"));
			infoDescription.html($(this).data("description"));
			infoExtra.html($(this).data("extra"));
		});

		$(this).mouseleave(function() {
			info.css({ display: 'none'});
		});

	});
});
</script>
JS;

	// Elements with this class will display a popup on hover
	public $popupElementClass='popupElement';

	public function getHTML() {
		return sprintf(self::$popupHTML, self::$arrowsDir.self::$leftArrow, self::$arrowsDir.self::$rightArrow);
	}

	public function getBlockAttr($title, $description='', $footer='') {
		return sprintf(' data-name="%s" data-description="%s" data-extra="%s"', $title, $description, $footer);
	}

	public function getJS() {
		return sprintf(self::$popupJS, $this->popupElementClass);
	}

}