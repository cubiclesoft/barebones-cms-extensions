Barebones CMS Extensions
========================

A list of approved extensions for Barebones CMS.  This is a fully automated repository updated daily.

See the bottom of this page for instructions on publishing new extensions.

@EXTENSIONS@

Publishing Extensions
---------------------

To publish an extension and get it onto this list, follow these steps:

1.  Write and test the new extension and put it on GitHub in a public repository.  Make sure the new extension does not conflict with Barebones CMS itself and attempts to avoid conflicts with other extensions (e.g. naming conflicts).
2.  Choose an appropriate license.  GPL/copyleft software and software without a license are not compatible and will be rejected.  MIT and LGPL licenses are fine.  Commercial extensions must be able to be fully evaluated (e.g. a free trial).
3.  [Submit the extension](https://barebonescms.com/extend/v2/publish/) - Connects your GitHub account to the Barebones CMS Extension publishing application.  The application only remembers what extensions you submit.
4.  Set up a "push only" webhook for the repository as follows:
	* Payload URL:  https://barebonescms.com/extend/v2/webhook/
	* Content type:  application/json
	* Secret:  The "Webhook Secret" from the "Manage Applications" screen.
5.  If all went well, reload the page and the "Webhook Status" will say "OK".  The content in parenthesis lets you know when the last successful webhook push or ping notification occurred (e.g. "OK (Today)").
6.  Once the webhook has been set up, the "Start Approval" option appears.  The link returns you to GitHub to create an issue on the issue tracker.
7.  Submit the issue one time and then wait.  It can take a few days for the approval process to begin.

Once an extension has been approved, it has to be updated at least once every 365 days to remain in the list.  Simply pushing to the repository will trigger the webhook and update the list accordingly.  Please refrain from updating on an automated basis.

To unpublish an extension, go to "Manage Extensions" in the [Barebones CMS Extension publishing application](https://barebonescms.com/extend/v2/publish/) and delete the extension from the list of approved extensions.  The extension will be removed from the list within 24 hours.  Note that git maintains a permanent log of changes, so it is always possible to go back in time.
