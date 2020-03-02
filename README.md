# JamfPro-DeviceQuerier
Get redireted to the Jamf inventory record by specifying the device serial number.

We wanted to use QR Codes as labels on our devices.

<p align="center">
<img src=".//QR_Code_Example.png" height="200">
</p>

In Jamf Pro, it is not possible to open an inventory record by specifying a device serial number within the url.
The url to a device record contains the Jamf Pro device id.

Therefore we ended up with a php script to parse Jamf Pro usind the device serial number and get redirected to the Jamf Pro inventory reccord.

The url has to be formated as follow:

|Type|URI|
| --- | --- |
| Mac  | http://yourdomain/?type=computer&sn=CAPPLESERIAL  |
| Device  | http://yourdomain/?type=device&sn=CAPPLESERIAL  |

In a upcoming release, we will support a URI only containing the serialnumber.
