## Assignment:

Create a popup form that collects user information and saves it to the database on a basic WordPress website that uses the Divi Parent Theme:

- Clicking the "**Send Me More Information**" button (in the "_How It Works_" section) triggers the popup.
- The popup is centered on screen and blurs the main site content.
- The popup fades in rather than appearing suddenly.
- Clicking outside the form closes the popup.
- Form data is saved without refreshing the page.
- Form data is sanitized prior to insertion into the database.
- Displays a message to the user after the save operation has completed or failed.
- Hide the popup and message after a reasonable time (also allow the user to close this manually).
- Match the site's color palette and aesthetic.
- Do not add any plugins or files (I'm adding this README.md).
- Please thoroughly document your thought process throughout.

## Notes

- The "**Send Me More Information**" button is an anchor that needs an `e.preventDefault()` to achieve the stated goal. A `<button type="button" />` approach seems preferable to me, but that was not an option for this challenge.
- Without having better control of `the_content()` of this page or a better way to inject this feature, I chose to do create the form with the shortcode `[fio_form]` in `functions.php` and used some DOM manipulation with jQuery to remove the form and append it to the end of the container.
- Centering the popup is done with `#main-content { positon: relative; }` `#figure-it-out { position: fixed; }`, and the blur is on `#main-content::before` and enabled by `.fio-open`, which is toggled by jQuery.
- Blurring the background content has terrible support across browsers and devices, so vendor prefixes and ostensibly redundant CSS are needed. Instead of this, I'd recommend darkening the background (as that has significantly better support).
- The fades of the popup are handled by the `.fadeIn()` and `.fadeOut` jQuery methods.
- Saving without refreshing the page is accomplished with _AJAX_ on the form's submission with an `e.preventDefault()`, which starts in _ncc-script.js_ and is processed via `submit_fio_form()` and enqueued via `add_ajax_script()` in _functions.php_.
- Hot Take: I normally try to rely on good naming instead of comments, limiting comments to explanations of novel concepts.
- Note: I've anonymized this as best I could and have tested the same, but it's possible something broke in translation. Notwithstanding, the linked sample does work correctly, and I believe this code works as long as there's a Divi Parent Theme, a file called loading.gif and a database table at `{$wpdb->prefix}fio_contacts` that has the correct fields.

## Sample:

- [https://sullivan.nursingcecentral.com/](https://sullivan.nursingcecentral.com/)
- [Sample (scrolled to relevant section)](https://sullivan.nursingcecentral.com/#ncc-more-info)
