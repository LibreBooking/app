NAME:

    Securimage - A PHP class for creating captcha images and audio with many options.

VERSION: 3.0

AUTHOR:

    Drew Phillips <drew@drew-phillips.com>

DOWNLOAD:

    The latest version can always be
    found at http://www.phpcaptcha.org

DOCUMENTATION:

    Online documentation of the class, methods, and variables can
    be found at http://www.phpcaptcha.org/Securimage_Docs/

REQUIREMENTS:
    PHP 5.2 or greater
    GD  2.0
    FreeType (Required, for TTF fonts)

SYNOPSIS:

    require_once 'securimage.php';

    $image = new Securimage();

    $image->show();

    // Code Validation

    $image = new Securimage();
    if ($image->check($_POST['code']) == true) {
      echo "Correct!";
    } else {
      echo "Sorry, wrong code.";
    }

DESCRIPTION:

    What is Securimage?

    Securimage is a PHP class that is used to generate and validate CAPTCHA images.
    The classes uses an existing PHP session or creates its own if none is found to store the
    CAPTCHA code.  Variables within the class are used to control the style and display of the image.
    The class supports TTF fonts and effects for strengthening the security of the image.
    An audible code can also be streamed to the browser for visually impared users.


COPYRIGHT:
    Copyright (c) 2011 Drew Phillips
    All rights reserved.

    Redistribution and use in source and binary forms, with or without modification,
    are permitted provided that the following conditions are met:

    - Redistributions of source code must retain the above copyright notice,
      this list of conditions and the following disclaimer.
    - Redistributions in binary form must reproduce the above copyright notice,
      this list of conditions and the following disclaimer in the documentation
      and/or other materials provided with the distribution.

    THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
    AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
    IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
    ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE
    LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
    CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
    SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
    INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
    CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
    ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
    POSSIBILITY OF SUCH DAMAGE.

    -----------------------------------------------------------------------------
    Flash code created for Securimage by Mario Romero (animario@hotmail.com)
    Many thanks for releasing this to the project!

    ------------------------------------------------------------------------------
    Portions of Securimage contain code from Han-Kwang Nienhuys' PHP captcha
        
    Han-Kwang Nienhuys' PHP captcha
    Copyright June 2007
    
    This copyright message and attribution must be preserved upon
    modification. Redistribution under other licenses is expressly allowed.
    Other licenses include GPL 2 or higher, BSD, and non-free licenses.
    The original, unrestricted version can be obtained from
    http://www.lagom.nl/linux/hkcaptcha/
    
    -------------------------------------------------------------------------------
    AHGBold.ttf (AlteHaasGroteskBold.ttf) font was created by Yann Le Coroller and is distributed as freeware
    
    Alte Haas Grotesk is a typeface that look like an helvetica printed in an old Muller-Brockmann Book.
    
    These fonts are freeware and can be distributed as long as they are
    together with this text file. 
    
    I would appreciate very much to see what you have done with it anyway.
    
    yann le coroller 
    www.yannlecoroller.com
    yann@lecoroller.com

