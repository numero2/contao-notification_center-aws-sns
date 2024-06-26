Contao Notification Center AWS SNS Gateway
===

[![](https://img.shields.io/packagist/v/numero2/contao-notification_center-aws-sns.svg?style=flat-square)](https://packagist.org/packages/numero2/contao-notification_center-aws-sns) [![](https://img.shields.io/badge/License-LGPL%20v3-blue.svg?style=flat-square)](http://www.gnu.org/licenses/lgpl-3.0)

About
--
The package adds AWS SNS to the Notification Center as a gateway.


System requirements
--

* [Contao 4](https://github.com/contao/contao)
* [Notification Center](https://packagist.org/packages/terminal42/notification_center)


Installation
--

* Install via Contao Manager or Composer (`composer require numero2/contao-notification_center-aws-sns`)
* Run a database update via the Contao-Installtool or using the [contao:migrate](https://docs.contao.org/dev/reference/commands/) command.
* Create a `SMS (Amazon Web Services SNS)` gateway in the Notification Center


How to generate API keys in AWS
--

1. Log in to the [AWS Management Console](https://console.aws.amazon.com/sns/v2/home)
2. Select a [Supported Region](https://docs.aws.amazon.com/sns/latest/dg/sms_supported-countries.html) from the top right of the console
3. Switch to the `IAM` Service
4. Select `Policies`and choose `Create policy`
5. Switch to the `JSON` tab and see the example below for a policy which can be used
6. Save the policy and switch to `Users` and click `Create user`
7. In `Permissions options` select `Attach policies directly` and choose the Policy created before
8. Click `Next` and then `Create user`
9. Back in the overview of users select the newly created user and switch to the tab `Security credentials`
10. In the section `Access keys` click the button `Create access key`
11. Choose the option `Other` and click `Next`, you can skip the `description tag` and choose `Create access key`
12. Make sure to save the generated `Access key` and the `Secret access key` for later configuration in Contao
13. Click on `Done` to finish the process

```json
{
    "Version": "2012-10-17",
    "Statement": [
        {
            "Effect": "Allow",
            "Action": [
                "sns:Publish"
            ],
            "Resource": [
                "*"
            ]
        }
    ]
}
```

🚨 Important information about phone number format
--

AWS requires the recipient phone number to be in [E.164](https://en.wikipedia.org/wiki/E.164) format (e.g `+49123456789`). For this purpose this extension provides a custom `Input validation` option called `Phone number (E.164)` for the form generator.

For a better user experience we suggest to use a small JavaScript called [International Telephone Input](https://github.com/jackocnr/intl-tel-input) which makes sure the inserted number matches the format.
