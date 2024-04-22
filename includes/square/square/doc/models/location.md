## Location

### Structure

`Location`

### Fields

| Name | Type | Tags | Description |
|  --- | --- | --- | --- |
| `id` | `?string` | Optional | The Square-issued ID of the location. |
| `name` | `?string` | Optional | The name of the location.<br>This information appears in the dashboard as the nickname. |
| `address` | [`?Address`](/doc/models/address.md) | Optional | Represents a physical address. |
| `timezone` | `?string` | Optional | The [IANA Timezone](https://www.iana.org/time-zones) identifier for<br>the timezone of the location. |
| `capabilities` | [`?(string[]) (LocationCapability)`](/doc/models/location-capability.md) | Optional | The Square features that are enabled for the location.<br>See [LocationCapability](#type-locationcapability) for possible values.<br>See [LocationCapability](#type-locationcapability) for possible values |
| `status` | [`?string (LocationStatus)`](/doc/models/location-status.md) | Optional | The status of the location, whether a location is active or inactive. |
| `createdAt` | `?string` | Optional | The time when the location was created, in RFC 3339 format. |
| `merchantId` | `?string` | Optional | The ID of the merchant that owns the location. |
| `country` | [`?string (Country)`](/doc/models/country.md) | Optional | Indicates the country associated with another entity, such as a business.<br>Values are in [ISO 3166-1-alpha-2 format](http://www.iso.org/iso/home/standards/country_codes.htm). |
| `languageCode` | `?string` | Optional | The language associated with the location, in<br>[BCP 47 format](https://tools.ietf.org/html/bcp47#appendix-A). |
| `currency` | [`?string (Currency)`](/doc/models/currency.md) | Optional | Indicates the associated currency for an amount of money. Values correspond<br>to [ISO 4217](https://wikipedia.org/wiki/ISO_4217). |
| `phoneNumber` | `?string` | Optional | The phone number of the location in human readable format. |
| `businessName` | `?string` | Optional | The business name of the location<br>This is the name visible to the customers of the location.<br>For example, this name appears on customer receipts. |
| `type` | [`?string (LocationType)`](/doc/models/location-type.md) | Optional | A location's physical or mobile type. |
| `websiteUrl` | `?string` | Optional | The website URL of the location. |
| `businessHours` | [`?BusinessHours`](/doc/models/business-hours.md) | Optional | Represents the hours of operation for a business location. |
| `businessEmail` | `?string` | Optional | The email of the location.<br>This email is visible to the customers of the location.<br>For example, the email appears on customer receipts. |
| `description` | `?string` | Optional | The description of the location. |
| `twitterUsername` | `?string` | Optional | The Twitter username of the location without the '@' symbol. |
| `instagramUsername` | `?string` | Optional | The Instagram username of the location without the '@' symbol. |
| `facebookUrl` | `?string` | Optional | The Facebook profile URL of the location. The URL should begin with 'facebook.com/'. |
| `coordinates` | [`?Coordinates`](/doc/models/coordinates.md) | Optional | Latitude and longitude coordinates. |
| `logoUrl` | `?string` | Optional | The URL of the logo image for the location. |
| `posBackgroundUrl` | `?string` | Optional | The URL of the Point of Sale background image for the location. |
| `mcc` | `?string` | Optional | The merchant category code (MCC) of the location, as standardized by ISO 18245.<br>The MCC describes the kind of goods or services sold at the location. |

### Example (as JSON)

```json
{
  "id": null,
  "name": null,
  "address": null,
  "timezone": null,
  "capabilities": null,
  "status": null,
  "created_at": null,
  "merchant_id": null,
  "country": null,
  "language_code": null,
  "currency": null,
  "phone_number": null,
  "business_name": null,
  "type": null,
  "website_url": null,
  "business_hours": null,
  "business_email": null,
  "description": null,
  "twitter_username": null,
  "instagram_username": null,
  "facebook_url": null,
  "coordinates": null,
  "logo_url": null,
  "pos_background_url": null,
  "mcc": null
}
```

