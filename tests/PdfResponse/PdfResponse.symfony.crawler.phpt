<?php

/**
 * Test: Joseki\Application\Responses\PdfResponse and Symfony crawler
 */

use Joseki\Application\Responses\PdfResponse;
use Nette\Http;
use Tester\Assert;

require __DIR__.'/../bootstrap.php';

test(
	static function(){
		$origData = file_get_contents(__DIR__.'/templates/example2.htm');
		$fileResponse = new PdfResponse($origData);
		$fileResponse->setSaveMode(PdfResponse::INLINE);
		$fileResponse->ignoreStylesInHTMLDocument = true;

		ob_start();
		$fileResponse->send(new Http\Request(new Http\UrlScript), new Http\Response);
		$actualData = ob_get_clean();
		$actualData = preg_replace('#/(CreationDate|ModDate|ID) .*#', '', $actualData);

		$expectedData = file_get_contents(__DIR__.'/expected/symfony.crawler.pdf');
		$expectedData = preg_replace('#/(CreationDate|ModDate|ID) .*#', '', $expectedData);

		Assert::same($expectedData, $actualData);
	}
);
