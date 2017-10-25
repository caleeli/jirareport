Feature: bugfix/HOR-3521
    The order by with user information does not work properly

    Scenario: bugfix/HOR-3521 with cases executed
        Then Open a browser
        Then Visit "http://processmaker2.david.test/sysworkflow/en/neoclassic/login/login"
        Then Login as "admin" "admin"

        Then Visit "http://processmaker2.david.test/sysworkflow/en/neoclassic/setup/main"
        Then Inside "/adminFrame"
        Then Click at "Environment"
        Then Inside "/adminFrame/setup-frame"
        Then Click at "User Name Display Format:"
        Then Click at "@lastName, @firstName (@userName)"
        Then Click at "Save Settings"

        Then Inside "/"
        Then Click at "Home"
        Then Inside "/casesFrame/casesSubFrame"
        Then Click at "Sent By"
        Then Click at "Sent By"
        Then Inside "/casesFrame"
        Then Click at "Participated"
        Then Inside "/casesFrame/casesSubFrame"
        Then Click at "Current User"
        Then Click at "Current User"

        Then Visit "http://processmaker2.david.test/sysworkflow/en/neoclassic/setup/main"
        Then Inside "/adminFrame"
        Then Click at "Environment"
        Then Inside "/adminFrame/setup-frame"
        Then Click at "User Name Display Format:"
        Then Click at "@lastName, @firstName"
        Then Click at "Save Settings"

        Then Inside "/"
        Then Click at "Home"
        Then Inside "/casesFrame/casesSubFrame"
        Then Click at "Sent By"
        Then Click at "Sent By"
        Then Inside "/casesFrame"
        Then Click at "Participated"
        Then Inside "/casesFrame/casesSubFrame"
        Then Click at "Current User"
        Then Click at "Current User"

        Then Visit "http://processmaker2.david.test/sysworkflow/en/neoclassic/setup/main"
        Then Inside "/adminFrame"
        Then Click at "Environment"
        Then Inside "/adminFrame/setup-frame"
        Then Click at "User Name Display Format:"
        Then Click at "@lastName @firstName"
        Then Click at "Save Settings"

        Then Inside "/"
        Then Click at "Home"
        Then Inside "/casesFrame/casesSubFrame"
        Then Click at "Sent By"
        Then Click at "Sent By"
        Then Inside "/casesFrame"
        Then Click at "Participated"
        Then Inside "/casesFrame/casesSubFrame"
        Then Click at "Current User"
        Then Click at "Current User"

        Then Visit "http://processmaker2.david.test/sysworkflow/en/neoclassic/setup/main"
        Then Inside "/adminFrame"
        Then Click at "Environment"
        Then Inside "/adminFrame/setup-frame"
        Then Click at "Environment"
        Then Click at "User Name Display Format:"
        Then Click at "@userName (@firstName @lastName)"
        Then Click at "Save Settings"

        Then Inside "/"
        Then Click at "Home"
        Then Inside "/casesFrame/casesSubFrame"
        Then Click at "Sent By"
        Then Click at "Sent By"
        Then Inside "/casesFrame"
        Then Click at "Participated"
        Then Inside "/casesFrame/casesSubFrame"
        Then Click at "Current User"
        Then Click at "Current User"

        Then Visit "http://processmaker2.david.test/sysworkflow/en/neoclassic/setup/main"
        Then Inside "/adminFrame"
        Then Click at "Environment"
        Then Inside "/adminFrame/setup-frame"
        Then Click at "User Name Display Format:"
        Then Click at "@userName"
        Then Click at "Save Settings"

        Then Inside "/"
        Then Click at "Home"
        Then Inside "/casesFrame/casesSubFrame"
        Then Click at "Sent By"
        Then Click at "Sent By"
        Then Inside "/casesFrame"
        Then Click at "Participated"
        Then Inside "/casesFrame/casesSubFrame"
        Then Click at "Current User"
        Then Click at "Current User"

        Then Visit "http://processmaker2.david.test/sysworkflow/en/neoclassic/setup/main"
        Then Inside "/adminFrame"
        Then Click at "Environment"
        Then Inside "/adminFrame/setup-frame"
        Then Click at "User Name Display Format:"
        Then Click at "@firstName @lastName (@userName)"
        Then Click at "Save Settings"

        Then Inside "/"
        Then Click at "Home"
        Then Inside "/casesFrame/casesSubFrame"
        Then Click at "Sent By"
        Then Click at "Sent By"
        Then Inside "/casesFrame"
        Then Click at "Participated"
        Then Inside "/casesFrame/casesSubFrame"
        Then Click at "Current User"
        Then Click at "Current User"

        Then Visit "http://processmaker2.david.test/sysworkflow/en/neoclassic/setup/main"
        Then Inside "/adminFrame"
        Then Click at "Environment"
        Then Inside "/adminFrame/setup-frame"
        Then Click at "User Name Display Format:"
        Then Click at "@firstName @lastName"
        Then Click at "Save Settings"

        Then Inside "/"
        Then Click at "Home"
        Then Inside "/casesFrame/casesSubFrame"
        Then Click at "Sent By"
        Then Click at "Sent By"
        Then Inside "/casesFrame"
        Then Click at "Participated"
        Then Inside "/casesFrame/casesSubFrame"
        Then Click at "Current User"
        Then Click at "Current User"

        Then Visit "http://processmaker2.david.test/sysworkflow/en/neoclassic/setup/main"
        Then Inside "/adminFrame"
        Then Click at "Environment"
        Then Inside "/adminFrame/setup-frame"
        Then Click at "User Name Display Format:"
        Then Click at "@lastName, @firstName (@userName)"
        Then Click at "Save Settings"
