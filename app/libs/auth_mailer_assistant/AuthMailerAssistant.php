<?php


class AuthMailerAssistant {
    private string $to; // user@example.com
    private string $subject; // Hello, World

    public function __construct(string $to, string $subject) {
        $this->to = $to;
        $this->subject = $subject;
    }

    /**
     * Provides content-type header for sending HTML email
     * @return string
     */
    private function getHTMLEmailHeaders(): string {
        return "MIME-Version: 1.0" . "\r\n" . "Content-type:text/html;charset=UTF-8" . "\r\n";
    }

    private function sendNow(string $body): bool {
        return mail($this->to, $this->subject, $body, $this->getHTMLEmailHeaders());
    }

    private function getButtonStyle(): string {
        return '.greenish-gradient-btn {
                      box-sizing: border-box;
                      position: relative;
                      margin-top: 8px;
                      font-family: sans-serif;
                      font-weight: bold;
                      letter-spacing: 1px;
                      text-decoration: none;
                      z-index: 1;
                      display: inline-flex;
                      align-items: center;
                      justify-content: center;
                      border-radius: 0;
                      overflow: hidden;
                      font-size: 16px;
                      text-transform: uppercase;
                      -webkit-font-smoothing: antialiased;
                      font-feature-settings: \'ss02\' on;
                      color: #fff;
                      transition: background .3s ease-in-out,border-color .3s ease-in-out,color .3s ease-in-out;
                      padding: 2px 16px;
                      height: 40px;
                  }
                  
                  .greenish-gradient-btn:hover {
                     color: black;
                  }
                  
                  .greenish-gradient-btn::before {
                     content: \'\';
                     display: block;
                     position: absolute;
                     width: calc(100% - 4px);
                     height: calc(100% - 4px);
                     top: 2px;
                     left: 2px;
                     z-index: -1;
                     background: #000;
                     transform: translate3d(0, 0, 0);
                     transition: background .3s ease-in-out;
                  }
                  
                  .greenish-gradient-btn::after {
                     content: \'\';
                     width: 100%;
                     height: 100%;
                     display: block;
                     position: absolute;
                     top: 0;
                     left: 0;
                     transform: translate3d(0, 0, 0);
                     backface-visibility: hidden;
                     z-index: -3;
                     background-position: 58% 50%;
                     background-size: 500%;
                     animation: gradient-shift 30s ease infinite;
                  }
                  
                  .greenish-gradient-btn::after, .greenish-gradient-btn:hover::before {
                     background: linear-gradient(272.22deg, #3BF0E4 -14.27%, #73F280 43.01%, #B2F4B6 96.82%);
                  }';
    }

    private function getTemplateHeader($userName): string {
        $body = '<style>';
        $body .= '.auth-mailer-assistant-template {
                     font-family: Helvetica Narrow, sans-serif;
                  }
                  
                  .auth-mailer-assistant-template .description {
                     margin: 0;
                  }';
        $body .= $this->getButtonStyle();
        $body .= '</style>';
        $body .= '<div class="auth-mailer-assistant-template">';
        return $body . '<h2>Hi ' . $userName . '</h2>';
    }

    private function getTemplateFooter($appName): string {
        $body  = '<p class="regards">Thanks! &#8211; The '.$appName.' team</p>';
        return $body . '</div>';
    }

    public function sendAccountVerificationEmail($userName, $callbackUrl, $appName): bool {
        $body = $this->getTemplateHeader($userName);
        $body .= '<p class="description">We just need to verify your email address before you can access your account.</p>';
        $body .= '<a class="greenish-gradient-btn" style="margin-top: 12px" href="'.$callbackUrl.'">Verify Now</a><br/>';
        $body .= $this->getTemplateFooter($appName);
        return $this->sendNow($body);
    }

    public function sendPasswordResetEmail($userName, $callbackUrl, $appName): bool {
        $body = $this->getTemplateHeader($userName);
        $body .= '<p class="description">Trouble signing in?</p>';
        $body .= '<p class="description" style="margin-top: 16px">Resetting your password is easy.</p>';
        $body .= '<p class="description" style="margin-top: 16px">Just press the button below and follow the instructions. We&#8217;ll have you up and running in no time.</p>';
        $body .= '<p class="description" style="margin-bottom: 8px"></p>';
        $body .= '<a class="greenish-gradient-btn" href="'.$callbackUrl.'">Reset Password</a><br/>';
        $body .= '<p class="description" style="margin-top: 12px">If you did not make this request then please ignore this email.</p>';
        $body .= $this->getTemplateFooter($appName);
        return $this->sendNow($body);
    }
}
