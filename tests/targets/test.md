```html
    <style>
        /* Breakpoints */

        @media only screen and (max-width: 600px) {
            .inner-body {
                width: 100% !important;
            }

            .footer {
                width: 100% !important;
            }
        }

        @media only screen and (max-width: 500px) {
            .button {
                width: 100% !important;
            }
        }

        /* Base */

        body,
        body *:not(html):not(style):not(br):not(tr):not(code) {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto,
            Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji",
            "Segoe UI Symbol";
            box-sizing: border-box;
        }

        body {
            height: 100%;
            width: 100% !important;
            background-color: #fff;
            color: #333;
            line-height: 1.4;
            margin: 0;
            -webkit-text-size-adjust: none;
        }

        a {
            color: #3045c1;
        }

        a img {
            border: none;
        }

        img {
            max-width: 100%;
        }

        /* Typography */

        h1 {
            color: #333;
            font-size: 21px;
            font-weight: bold;
            line-height: 1.2;
            margin-top: 0;
            margin-bottom: 21px;
            text-align: left;
        }

        h2 {
            color: #333;
            font-size: 16px;
            font-weight: bold;
            line-height: 1.2;
            margin-top: 0;
            margin-bottom: 16px;
            text-align: left;
        }

        h3 {
            color: #333;
            font-size: 12px;
            font-weight: bold;
            line-height: 1.2;
            margin-top: 0;
            margin-bottom: 3px;
            text-align: left;
            text-transform: uppercase;
        }

        p {
            color: #333;
            font-size: 16px;
            line-height: 1.5;
            margin-top: 0;
            text-align: left;
        }

        ul,
        ol {
            font-size: 16px;
            line-height: 1.5;
            padding-left: 35px;
            text-align: left;
        }

        strong {
            font-weight: 600;
        }

        blockquote {
            background: #fafafa;
            border-radius: 4px;
            color: #666;
            font-size: 19px;
            margin: 35px 0;
            padding: 25px 35px;
            font-style: italic;
        }

        blockquote p {
            font-size: 19px;
            color: #666;
            margin: 0px;
        }

        code {
            font-family: ui-monospace,
            Menlo, Monaco,
            "Cascadia Mono", "Segoe UI Mono",
            "Roboto Mono",
            "Oxygen Mono",
            "Ubuntu Monospace",
            "Source Code Pro",
            "Fira Mono",
            "Droid Sans Mono",
            "Courier New", monospace;
        }

        pre {
            white-space: pre;
        }

        pre code {
            font-size: 14px;
            line-height: 1.5;
            border-radius: 4px;
            padding: 25px;
            margin: 25px 0;
            display: block;
            overflow-x: auto;
            white-space: pre;
        }

        /* Layout */

        .wrapper {
            background-color: #fff;
            margin: 0;
            padding: 0;
            width: 100%;
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
            -premailer-width: 100%;
        }

        .content {
            margin: 0;
            padding: 0;
            width: 100%;
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
            -premailer-width: 100%;
        }

        /* Header */

        .header {
            padding: 50px 0;
            text-align: center;
        }

        .header a {
            color: #E11D48;
            font-size: 19px;
            font-weight: 900;
            text-decoration: none;
        
            letter-spacing: 1px;
        }

        /* Body */

        .body {
            margin: 0;
            padding: 0;
            width: 100%;
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
            -premailer-width: 100%;
        }

        .inner-body {
            background-color: #ffffff;
            margin: 0 auto;
            padding: 0 20px;
            width: 570px;
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
            -premailer-width: 570px;
        }

        /* Footer */

        .footer {
            margin: 0 auto;
            padding: 50px 0;
            text-align: center;
            width: 570px;
            color: #999;
            font-size: 12px;
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
            -premailer-width: 570px;
        }

        .footer p {
            color: #999;
            font-size: 12px;
            text-align: center;
        }

        .footer a {
            color: #999;
            font-size: 12px;
            text-decoration: none;
        }

        /* Buttons */

        .button-wrapper {
            margin: 35px 0;
            text-align: center;
        }

        .button {
            display: inline-block;
            padding: 10px 24px;
            background-color: #3045c1;
            color: #fff;
            white-space: nowrap;
            border-radius: 4px;
            font-weight: 700;
            text-decoration: none;
        }

        /* Table */

        .inner-body table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin: 25px 0;
        }

        .inner-body table th {
            font-size: 10px;
            text-align: left;
            padding: 6px 10px;
            background: #fafafa;
            border-bottom: 1px solid #ddd;
            text-transform: uppercase;
        }

        .inner-body table td {
            font-size: 14px;
            text-align: left;
            padding: 6px 10px;
            border-bottom: 1px solid #ddd;
        }

        .inner-body table td p,
        .inner-body table td ul,
        .inner-body table td ol {
            font-size: 14px;
        }
    </style>
```