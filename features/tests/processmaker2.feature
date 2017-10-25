Feature: bugfix/HOR-3911
    NO FUNCIONA
        Then Visit "http://david.test/pminstall.php?branch=bugfix/HOR-3901"

    Scenario: bugfix/HOR-3911
        Then Open a browser
        Then Visit "http://processmaker2.david.test"
        Then Click at "Next"
        Then Click on "ext-gen33"
        Then Click at "I agree"
        Then Click on "ext-gen33"
        Then Click on "db_hostname"
        Then Write on "db_hostname" "127.0.0.1"
        Then Write on "db_password" "root"
        Then Click at "Test Connection"
        Then Click at "Next"
        Then Write on "adminPassword" "admin"
        Then Write on "confirmPassword" "admin"
        Then Click on "changeDBNames"
        Then Write on "wfDatabase" "wf_workflow2"
        Then Click on "deleteDB"
        Then Click at "Check Workspace Configuration"
        Then Click at "Finish"
        Then Wait for "OK" "1000000" ms
        Then Click on "ext-gen239"
        Then Write on "form[licenseFile]" "/home/david.callizaya/jiraMonitor/license_7ubh3dHS2+bWqaOlnZ0.dat"
        Then Click on "form[updateButton]"
        Then Click on "getStarted"
