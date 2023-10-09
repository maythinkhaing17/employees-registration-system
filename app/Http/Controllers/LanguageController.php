<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class LanguagesController
 * @author May Thin Khaing
 * @created 05/07/2023
 */
class LanguageController extends Controller
{
    /**
     * Switches the language.
     * @author May Thin Khaing
     * @created 06/07/2023
     * @param Request $request The current request object.
     * @param string $locale The selected language/locale.
     * @return RedirectResponse Redirects back to the previous page.
     */
    public function switch(Request $request, $locale)
    {
        // Store the selected language in the session
        $request->session()->put('locale', $locale);

        // Redirect back to the previous page
        return redirect()->back();
    }
}
