## Upsert Catalog Object Response

### Structure

`UpsertCatalogObjectResponse`

### Fields

| Name | Type | Tags | Description |
|  --- | --- | --- | --- |
| `errors` | [`?(Error[])`](/doc/models/error.md) | Optional | Information on any errors encountered. |
| `catalogObject` | [`?CatalogObject`](/doc/models/catalog-object.md) | Optional | -  |
| `idMappings` | [`?(CatalogIdMapping[])`](/doc/models/catalog-id-mapping.md) | Optional | The mapping between client and server IDs for this upsert. |

### Example (as JSON)

```json
{
  "catalog_object": {
    "type": "ITEM",
    "id": "7SB3ZQYJ5GDMVFL7JK46JCHT",
    "updated_at": "2016-11-16T22:32:42.996Z",
    "version": 1479335562996,
    "is_deleted": false,
    "item_data": {
      "name": "Cocoa",
      "description": "Hot chocolate",
      "abbreviation": "Ch"
    }
  },
  "id_mappings": [
    {
      "client_object_id": "#Cocoa",
      "object_id": "7SB3ZQYJ5GDMVFL7JK46JCHT"
    }
  ]
}
```

