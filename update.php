<?php
	// This runs the main updater.  Requires PHP and git on the path and repo commit access.  That last part you, of course, don't have.
	// (C) 2018 CubicleSoft.  All Rights Reserved.

	if (!isset($_SERVER["argc"]) || !$_SERVER["argc"])
	{
		echo "This file is intended to be run from the command-line.";

		exit();
	}

	$rootpath = str_replace("\\", "/", dirname(__FILE__));

	function GitRepoChanged($rootpath)
	{
		chdir($rootpath);
		ob_start();
		system("git status");
		$data = ob_get_contents();
		ob_end_flush();

		return (stripos($data, "Changes not staged for commit:") !== false || stripos($data, "Untracked files:") !== false);
	}

	function CommitRepo($rootpath)
	{
		if (GitRepoChanged($rootpath))
		{
			// Commit all the things.
			system("git add -A");
			system("git commit -m \"Updated.\"");
			system("git push origin master");
		}
	}

	// Retrieve the latest lists of approved extensions.
	require_once $rootpath . "/support/web_browser.php";

	$web = new WebBrowser();

	$result = $web->Process("https://barebonescms.com/extend/v2/");
	if (!$result["success"] || $result["response"]["code"] != 200)
	{
		echo "Unable to retrieve extensions list.\n";

		exit();
	}

	$data = json_decode($result["body"], true);
	if (!is_array($data) || !$data["success"] || !isset($data["lists"]))
	{
		var_dump($result["body"]);

		echo "Unexpected server response.\n";

		exit();
	}

	$typemap = array(
		"plugin" => "Plugins",
		"language" => "Language Packs",
		"api" => "API Extensions",
		"other" => "Other Extensions"
	);

	$content = "";
	foreach ($typemap as $type => $disp)
	{
		if (!isset($data["lists"][$type]))  continue;

		$content .= $disp . "\n";
		$content .= str_repeat("-", strlen($disp)) . "\n\n";

		foreach ($data["lists"][$type] as $extension)
		{
			$content .= "* [" . $extension["name"] . "](" . $extension["url"] . ") - " . date("M j, Y", $extension["lastupdated"]) . " - " . $extension["desc"] . "\n";
		}

		$content .= "\n";
	}

	if ($content === "")  $content .= "No extensions are available at this time.";

	// Generate README.
	$data = file_get_contents($rootpath . "/readme_src/README.md");
	$data = str_replace("@EXTENSIONS@", rtrim($content), $data);

	file_put_contents($rootpath . "/README.md", $data);

	CommitRepo($rootpath);
?>