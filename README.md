# enki-session-test

This repository's only purpose is to test the session transferal from UQLAIS to any app running on the Enki servers.
The process works as follows:
1. Enki compares $_SESSION vs $_COOKIES. If user_group is different, proceed to #2. If not, finish.
2. Enki contacts UQLAPP /account with the $_COOKIE['UQL_ID']. 
3. Returned data is saved in the local session database in the "old" format

For this test, we get the "Enki" server to contact a locally running UQLAIS. In production, UQLAPP simply acts as a
cache / buffer, so the result is exactly the same.

## Usage
- Make sure the new UQLAIS is running locally
- etc