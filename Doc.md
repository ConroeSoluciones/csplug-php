# Variables

{{ url }} = "https://csplug-st.csfacturacion.com"

### Recurso de EmisorHijoSeries

**List endpoint: GET {{ url }}/emisores-hijos/{{ rfc_emisor }}/series**

```json
{
  "message": "Exito",
  "data": [
    {
      "id_serie": 13400,
      "id_emisor": 660,
      "id_plantilla": 78,
      "serie": "TS636",
      "rango_inicial": 1,
      "ruta_logo": null,
      "fecha": "2026-02-19",
      "tipo": 1,
      "config": null,
      "status": null,
      "version": 2,
      "estilo_conceptos": null,
      "estilo_totales": null,
      "decimales": 2,
      "rfc_emisor": "AAA010101AAA"
    },
    {
      "id_serie": 13401,
      "id_emisor": 660,
      "id_plantilla": 78,
      "serie": "TS141",
      "rango_inicial": 1,
      "ruta_logo": null,
      "fecha": "2026-02-19",
      "tipo": 1,
      "config": null,
      "status": null,
      "version": 2,
      "estilo_conceptos": null,
      "estilo_totales": null,
      "decimales": 2,
      "rfc_emisor": "AAA010101AAA"
    },
    {
      "id_serie": 13404,
      "id_emisor": 660,
      "id_plantilla": 78,
      "serie": "A",
      "rango_inicial": 1,
      "ruta_logo": null,
      "fecha": "2026-02-21",
      "tipo": 1,
      "config": null,
      "status": null,
      "version": 2,
      "estilo_conceptos": null,
      "estilo_totales": null,
      "decimales": 2,
      "rfc_emisor": "AAA010101AAA"
    },
    {
      "id_serie": 13416,
      "id_emisor": 660,
      "id_plantilla": 78,
      "serie": "Z",
      "rango_inicial": 1,
      "ruta_logo": null,
      "fecha": "2026-03-11",
      "tipo": 1,
      "config": null,
      "status": null,
      "version": 2,
      "estilo_conceptos": null,
      "estilo_totales": null,
      "decimales": 2,
      "rfc_emisor": "AAA010101AAA"
    },
    {
      "id_serie": 13417,
      "id_emisor": 660,
      "id_plantilla": 78,
      "serie": "ZA",
      "rango_inicial": 1,
      "ruta_logo": null,
      "fecha": "2026-03-11",
      "tipo": 1,
      "config": null,
      "status": null,
      "version": 2,
      "estilo_conceptos": null,
      "estilo_totales": null,
      "decimales": 2,
      "rfc_emisor": "AAA010101AAA"
    },
    {
      "id_serie": 13418,
      "id_emisor": 660,
      "id_plantilla": 78,
      "serie": "B",
      "rango_inicial": 1,
      "ruta_logo": null,
      "fecha": "2026-03-11",
      "tipo": 1,
      "config": null,
      "status": null,
      "version": 2,
      "estilo_conceptos": null,
      "estilo_totales": null,
      "decimales": 2,
      "rfc_emisor": "AAA010101AAA"
    },
    {
      "id_serie": 13419,
      "id_emisor": 660,
      "id_plantilla": 78,
      "serie": "PAGO",
      "rango_inicial": 1,
      "ruta_logo": null,
      "fecha": "2026-03-11",
      "tipo": 1,
      "config": null,
      "status": null,
      "version": 2,
      "estilo_conceptos": null,
      "estilo_totales": null,
      "decimales": 2,
      "rfc_emisor": "AAA010101AAA"
    },
    {
      "id_serie": 13420,
      "id_emisor": 660,
      "id_plantilla": 78,
      "serie": "NOM",
      "rango_inicial": 1,
      "ruta_logo": null,
      "fecha": "2026-03-11",
      "tipo": 1,
      "config": null,
      "status": null,
      "version": 2,
      "estilo_conceptos": null,
      "estilo_totales": null,
      "decimales": 2,
      "rfc_emisor": "AAA010101AAA"
    }
  ],
  "pagination": {
    "current_page": 1,
    "per_page": 15,
    "total": 8,
    "last_page": 1,
    "next_page_url": null,
    "prev_page_url": null
  }
}
```
**Create endpoint: POST {{ url }}/emisores-hijos/{{ rfc_emisor }}/series**

**Descripcion**: Crea una nueva serie para un emisor hijo específico, pero aqui hay que tener las siguientes consideraciones:
- El emisor hijo debe tener una plantilla asignada previamente, de lo contrario no se podrá crear la serie. (Por regla del servicio, siempre tiene asociada una plantilla llamada "Default" con id 78, por lo que se puede usar esa plantilla para pruebas)
- El campo "serie" es una cadena que representa el nombre de la serie, y debe ser único para el emisor hijo.
- El campo "version" es un entero que representa si la serie es para CFDI o Retenciones, donde 2 es para CFDI y 3 es para Retenciones, de ser posible crear enums para esto
- El campo "tipo" es un entero que representa el motivo para el que se usara la serie, esto solo aplica para cfdi, de ser posible, obliga a usar un enum para este campo en retenciones no debe existir, sus valores son los siguientes:
    - 1: Uso general
    - 2: Nómina
    - 3: Pagos
- Los campos "serie" y "version" son obligatorios, mientras que "tipo" es opcional pero si se proporciona debe ser un valor válido según lo mencionado anteriormente.

**Ejemplo de request:**
```json
{
  "serie": "TEST_SDK",
  "tipo": 1,
  "version": 2,
}
```


**Respuesta exitosa (201):**
```json
{
  "message": "Serie creada para emisor hijo",
  "data": {
    "id_serie": 13427,
    "id_emisor": 660,
    "id_plantilla": 78,
    "serie": "TEST_SDK",
    "rango_inicial": 1,
    "ruta_logo": null,
    "fecha": "2026-03-27",
    "tipo": 1,
    "config": null,
    "status": null,
    "version": "2",
    "estilo_conceptos": null,
    "estilo_totales": null,
    "decimales": 2,
    "rfc_emisor": "AAA010101AAA"
  }
}
```

Tambien existe un endpoint para actualizar una serie existente, el cual es `PUT {{ url }}/emisores-hijos/{{ rfc_emisor }}/series/{{ id_serie }}` y tiene la misma estructura de request que el endpoint de creación, como es PUT, todos los campos se deben enviar aunque no se quieran actualizar, ya que si no se envian, esos campos se actualizaran a null.

**Configuraciones de Serie**

El campo`config` permite almacenar configuraciones adicionales para la serie.
Para agregar configuraciones se debe de hacer mediante un endpoint específico para actualizar la configuración de la serie.

El cual se encuentra en la ruta `POST {{ url }}/emisores-hijos/{{ rfc_emisor }}/series/{{ id_serie }}/config`

Los siguientes campos son los que se pueden configurar en la serie, todos son opcionales y pueden ser nulos, pero si se intenta crear una configuracion para la serie el campo template es el unico campo requerido:
```php
    $campos = [
        'logo',
        'logo_binary',
        'decimal_quantity',
        'orientation',
        'accent_color',
        'font_color',
        'nombre_comercial_enabled',
        'nombre_comercial',
        'sucursal',
        'template',
    ];
```
- El campo `template` es un string que representa la plantilla que se usará para la serie, este campo es obligatorio si se quiere crear una configuración para la serie, y debe ser igual a la clave de alguna de las plantillas disponibles para la contratacion, por ejemplo "default".
- El campo `logo` debe ser un string en formato base64, estilo "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+5n2VAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAALEgAACxIB0t1+/AAAADlJREFUeJztwTEBAAAAwqD1T20ND6AAAAAAAAAAAAAAAAPgG4AAGiQABVQAAcAAAAASUVORK5CYII="
- El campo `orientation` debe ser un string con los valores "portrait" o "landscape".
- Los campos `accent_color` y `font_color` deben ser strings en formato hexadecimal representando un color, por ejemplo "#FF5733".

Ejemplo de request para configurar una serie:
```json
{
  "config": {
    "template": "default",
    "orientation": "landscape",
    "accent_color": "#FF5733",
    "font_color": "#333333"
  }
}
```

Ejemplo del response:

```json
{
  "message": "Configuración actualizada para la serie",
  "data": {
    "logo":  null,
    "logo_binary":  null,
    "decimal_quantity":  null,
    "orientation":  "landscape",
    "accent_color":  "#FF5733",
    "font_color":  "#333333",
    "nombre_comercial_enabled":  null,
    "nombre_comercial":  null,
    "sucursal":  null
  }
}
```

**Plantillas**

Para obtener las plantillas disponibles para la contratacion se puede hacer una petición GET a la ruta `GET {{ url }}/plantillas`.

Response ejemplo:
```json
{
  "message": "Exito",
  "data": [
    {
      "id_plantilla": 78,
      "clave_plantilla": "default",
      "nombre_plantilla": "CFDI (INCLUYE TODOS LOS COMPLEMENTOS)",
      "descripcion": "FACTURA INGRESO, EGRESO CFDI 4.0 <br>Plantilla general para CFDI 3.3 <br>Tama&ntilde;o logo 150x150",
      "ruta_plantilla": "../plantillas/plantillaV33.html",
      "vista_previa": "../plantillas/vistasplantillas/CC-2-AAA010101AAA33-001.jpg",
      "fecha": "2022-04-07",
      "tipo": 1,
      "version": 4,
      "version_libreria": 1,
      "status": null,
      "nombre_service": "default"
    },
    {
      "id_plantilla": 87,
      "clave_plantilla": "default",
      "nombre_plantilla": "Retenciones 2.0",
      "descripcion": "Retenciones 2.0\r\n",
      "ruta_plantilla": "",
      "vista_previa": "",
      "fecha": "2022-08-04",
      "tipo": 3,
      "version": 3,
      "version_libreria": 1,
      "status": null,
      "nombre_service": null
    }
  ],
  "pagination": {
    "current_page": 1,
    "per_page": 15,
    "total": 2,
    "last_page": 1,
    "next_page_url": null,
    "prev_page_url": null
  }
}
```

**Certificados Para emisores hijos**

El certificado para emisores hijos se maneja de manera independiente al certificado del emisor principal, esto significa que cada emisor hijo puede tener su propio certificado.

Endpoint para subir el certificado del emisor hijo: `POST {{ url }}/emisores-hijos/{{ rfc_emisor }}/certificados`

Request ejemplo:
```json
{
  "cer": "MIIFgzCCA2ugAwIBAgIUMzAwMDEwMDAwMDA1MDAwMDMzNjIwDQYJKoZIhvcNAQELBQAwggErMQ8wDQYDVQQDDAZBQyBVQVQxLjAsBgNVBAoMJVNFUlZJQ0lPIERFIEFETUlOSVNUUkFDSU9OIFRSSUJVVEFSSUExGjAYBgNVBAsMEVNBVC1JRVMgQXV0aG9yaXR5MSgwJgYJKoZIhvcNAQkBFhlvc2Nhci5tYXJ0aW5lekBzYXQuZ29iLm14MR0wGwYDVQQJDBQzcmEgY2VycmFkYSBkZSBjYWxpejEOMAwGA1UEEQwFMDYzNzAxCzAJBgNVBAYTAk1YMRkwFwYDVQQIDBBDSVVEQUQgREUgTUVYSUNPMREwDwYDVQQHDAhDT1lPQUNBTjERMA8GA1UELRMIMi41LjQuNDUxJTAjBgkqhkiG9w0BCQITFnJlc3BvbnNhYmxlOiBBQ0RNQS1TQVQwHhcNMjMwNTE1MTY1NzU3WhcNMjcwNTE1MTY1NzU3WjCBqjEeMBwGA1UEAxMVTUFSSUEgV0FURU1CRVIgVE9SUkVTMR4wHAYDVQQpExVNQVJJQSBXQVRFTUJFUiBUT1JSRVMxHjAcBgNVBAoTFU1BUklBIFdBVEVNQkVSIFRPUlJFUzEWMBQGA1UELRMNV0FUTTY0MDkxN0o0NTEbMBkGA1UEBRMSV0FUTTY0MDkxN01IR1RSUjAxMRMwEQYDVQQLEwpTdWN1cnNhbCAxMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAueKA188y59jth2cxGI3IRAwKXA77p7bOOli5hb5Jsv3GdWdnrjg+hldmCnfV5OnfAj/oGKkD8UcpIEir1Yk9iz1CYN+p7uSndp0cwp6ExsCYY9GRC0FWPNY/ZXwc/CHOKW3Y2iXlWJDBfyhLCKC+4oTkBzp+2KmjRNIVdsJoVvZH/KSs6U7j+coos9ygrbvQk+i1UrC5L0/JhTA44Rp2l4Kj9sVhz1PUqA+Lq9rLMkvsDBC6NS3NlLhPsJ+4c5PlLTikc3LcLZVtBp/rz20pct+AAskGwDZe8/HVRecehb71pDaPCdHyj6j3Z3NJIArxLm6ecZZguWaSrA1LuSSOnQIDAQABox0wGzAMBgNVHRMBAf8EAjAAMAsGA1UdDwQEAwIGwDANBgkqhkiG9w0BAQsFAAOCAgEAdu2JXVqSJ/0nLLFIq+3bodv9dHgR8RraMTrMugBToKut69OEZ2+59rUzaYEOyfCnkoOcrpRikTH80QNvYyu4n2PaGuf6labBGloR8rkWgql96vB+xKTzhdF/kc9DwEYIWZgGAeamZ3X4CofJs10oYBUDCSdwOt4PPb9mDB7pKw6yH0M/OqLOFVCC7BAk4ER4pcuj5T/xBMLFcb09/cvUg/+/jETjHHrnS+BuBzXTvCUtLHBr6IOOmWAr8B8Onmph7FrJY/2lmZMLlGVY0POUa/4i+M8wntvfXxlyUoYc+5g4ZAdj2b6oj3gh2dDldkwV6K0ekPSChVcKqPgjsL9y7RfT+1miEwbEf+W5OeKE67MQoEtScJ7vuXXP1Gz/juUMyQY+BC/n2UmiLCTqAoXYybyTKiK1gV9Ymmxk1/LZUq6fvOuZoyOSgC0znlGg874BAwQ65WJwq34IOsN0grCC/pVPbLJpUUp9ZzDMMqAk6yC7UDHacQI7hO4b7TKn7vz150vp2ZJzjFwP3zUKBlF+VmWsMmpiINfguo/owVR4NYzy5RaZLkXbuiomU74VIsJySpo8SpUouvmkZjbMDbcsMD1rblXn+sCozz2altEP6DJYANqtbDy9hrWjIwTy0HbXR7Wg1ASz1fmV4YyPBks5otf0DomGmzLSEEHPaBNuDCU=",
  "key": "MIIFDjBABgkqhkiG9w0BBQ0wMzAbBgkqhkiG9w0BBQwwDgQIAgEAAoIBAQACAggAMBQGCCqGSIb3DQMHBAgwggS8AgEAMASCBMh4EHl7aNSCaMDA1VlRoXCZ5UUmqErAbucRFLOMmsAaFNeEsy2nBLbK4m8O2nxQvp9B2waihLcP3PGhwvaRLK92bdZPi2yhfE7zxBrmhWnC35fJBap6Wv6frbAmublgRmTIrvjZq7nwEMNqFOrkMbwJFXTvL6fNtAsTWItNaquzJu/B6YVJ8WHgbCQ7StPu7Y5JRdWhLg7FvZppo/jS7hDAL00Bn3ug1x3KKUW0CClBAihfTYpwtCRCl+Ga9qlPR7OgW8862RvyA/wcFboKXHsQvhOZtrAdL8fz/D5j4lJgAj4XuCSAu6uNLWUb//IFpsxnB8YQGKxFuoBNE6YfY7hHBG1B655nyxWy2nHIJND99NNTwH8g/F6vXR4C+uZc7q0hFRvDMYb1SFKSzeuhxOfeOuwgpJH2hvN+E7yttR8Rx9lpDcNpM7K+SlIpEPq0OwJMKj535F6EgM3a2Y6VJWB1p3QCzV4UUSVWLCLpBUMAbPvdApv/noACBNinYPeMLnDZPRfJNT65VU8oQlODpY+sg3E1ido0meSbDTwfXdaY9qZMhE0tnXnR84tKmfz4VhQGZyS6iipBw1UfeJB4OjN23iwffTzNJAm1sYnJ0toiNsinRNyU6stxYxzqhje3Tet0ZUXlm8aadVgi7wRRw8eLh0Dey5eO1auGOnB0eDUSmaAH73bArNbSbxFLabvpKtOaVriv020ve28AaoUqM0PQsu3uDLStomnMF/q5aIcDPHx/b0loPhJ9yQzXnAdYRsBxy0KamBtqwlpOucJkgKJxT6/yL7rhYKCknoYa1ohIqQP1YoxwJ61ZaMgR69i68wd8Y3a906iHT9BuDEyidBKHuEx7YqHCVqmL/hxU2WqI05XrbjUxXH3b+FyoDgcgJvwpSNOt+KHWa4fjbCcH5hpj3+DHBW0x/x9dAjofjIuPAqj8Wa9aAl9HB229geXW2A2jvYSqoPfI5nJOx2FsO35Dqbk7lpDqSHh0psL6rir6P3nkQNvHIgXG7KQ5gxfnNV/SeIm4ycDf8E1F6e1B00NrbvjucEyQxRo8mxTdtIOTCV6nrtWc8JOw1ZETAjrWzmc7SLi63zyExfgCvgVmWO7xj8rNy6bj1XSeWaZg4jwSOgRTeyZZDTof3r9FC+oDxVvqDbqSwu0enYqtareYej9DEHKbwcfJTyoRt6v6iUlOEwCIY0Hig+a71ic9D8aIuaPOxNlT0EydTZ1urm2u1vTtPkxrYuD261CRaHu8jYaJEDd4Z63v5HC1KR0IcNb/ZxLqWpIM01WyCDJELf4X/n6rwL+octDmfzHM6mPaI0wtr2ayqjz5DriIVXHrLNPzeqbN/R+iP9trgH0ztQ+II5x8kG3brpVwH6ppdwK5RHFHu78nZU7I0zsRjWhq0GxshyPmfB15nmTyUS7ylMzXGphuvH/Ncdj0gRnrFSzOLWGXQzdd+D6LKs1bFOY7y8bXPJmrmkuMdPgv0c52wktg2z779fVpPJrPMCBTxnFm50RzpBEWfoX/GgGAga+rCIcd+GUvmk/e52V0mSbu2nHnnaguC5BN7a+czKIFgVpClFkx8GtLeNs2TPkOm8Qa+2FCcN/b8FiD8ABVQqQ1aZuZbwMMtYEGoMtK+xw=",
  "password": "12345678a"
}
```

Todos los campos son obligatorios:
- `cer`: El certificado en formato base64.
- `key`: La clave privada en formato base64.
- `password`: La contraseña de la clave privada.

El endpoint para listar los certificados de un emisor hijo es `GET {{ url }}/emisores-hijos/{{ rfc_emisor }}/certificados`

Response ejemplo:
```json
{
  "message": "Exito",
  "data": [
    {
      "id_cert_sello": 9149,
      "id_emisor": null,
      "cer": "MIIFijCCA3KgAwIBAgIUMzAwMDEwMDAwMDA0MDAwMDIzMzUwDQYJKoZIhvcNAQELBQAwggErMQ8wDQYDVQQDDAZBQyBVQVQxLjAsBgNVBAoMJVNFUlZJQ0lPIERFIEFETUlOSVNUUkFDSU9OIFRSSUJVVEFSSUExGjAYBgNVBAsMEVNBVC1JRVMgQXV0aG9yaXR5MSgwJgYJKoZIhvcNAQkBFhlvc2Nhci5tYXJ0aW5lekBzYXQuZ29iLm14MR0wGwYDVQQJDBQzcmEgY2VycmFkYSBkZSBjYWRpejEOMAwGA1UEEQwFMDYzNzAxCzAJBgNVBAYTAk1YMRkwFwYDVQQIDBBDSVVEQUQgREUgTUVYSUNPMREwDwYDVQQHDAhDT1lPQUNBTjERMA8GA1UELRMIMi41LjQuNDUxJTAjBgkqhkiG9w0BCQITFnJlc3BvbnNhYmxlOiBBQ0RNQS1TQVQwHhcNMTkwNTI5MTk1MDAxWhcNMjMwNTI5MTk1MDAxWjCBsTEdMBsGA1UEAxMUWE9DSElMVCBDQVNBUyBDSEFWRVoxHTAbBgNVBCkTFFhPQ0hJTFQgQ0FTQVMgQ0hBVkVaMR0wGwYDVQQKExRYT0NISUxUIENBU0FTIENIQVZFWjEWMBQGA1UELRMNQ0FDWDc2MDUxMDFQODEbMBkGA1UEBRMSQ0FDWDc2MDUxME1HVFNIQzA0MR0wGwYDVQQLExRYT0NISUxUIENBU0FTIENIQVZFWjCCASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoCggEBAKvYaTyUuvtUIwymg88xS3Ri7W2J758lusEgwUaxdyIyxLQK2736yrK6RotjDu7pfbzqD5CyJ6gkT70x29QNe5MHUgcNPnARoYK2+0a0kWjpweNqjb0pCOMevUCzblF72c7MkErbW5qolIRIsI4UFSZOlLDI9O9lKm0Tk85Ab0siaqUefGl9lOOkjPT7Pr/CkHk4jxZJOzY2cWVey00vgFh/t9xxbF6Rvi738dfZ9R9h2TVEpaRRYb+m4rpTMos6HEfmhuKSsNe2/M8NDxC4zkcwdC5WS9NhNd4kUQ+7TFLmIo14tOXXSBZVVsg49/L+lq/eh44K1Ze3iSW9M7Ii8mECAwEAAaMdMBswDAYDVR0TAQH/BAIwADALBgNVHQ8EBAMCBsAwDQYJKoZIhvcNAQELBQADggIBAK1bJ6vhkqIF0Y4XnDUFQ/nZUOsQCXbs+czwu62kVaOffHWcKhJ1mTaSwkmFoqykV3VAib7RYKYTXcERow21uGEfnOhNxeSi4l2An7y6PtJOGy4wTjAX++iAeoh+ZDel3VBhvNYv6IZAcsVqdTl0Mfs/E7EuCc6YqumEBTbFTMcp92A31HWHqkI+UnXcogYndsaIK2m+iER6AHhUokfOjOiSJmSEovaXmaJVkmjbv3g07FeMB2fZ8fp3rrRtHjgTzbZyPY2LjhBnV/0vaTnGZH4l1RWZ+dgFn5/09GJJYLgaTBHpuRNBI6JRQ9/iR4NMjOEbNXDIpKibnIg3zG1yqQtUwQBUic0lF958n1KOg7fM+Msgq9Fjg2FY3aI2DAoGWKJR8PTiFbXy+Arpzd669QWzgIusT7KLwlFhKm+a+9dmE2lp0WUj2QH0drJdfSuvqA9ZIu3I0yvnpUT0jlun0PZyoloTOd5X+8z2kLSAxbZaOu9I4XATcwZntZK0FIueh4Htom524ne/MNp6nEXzpxV4HPiW626VoykB4AHJwIp7ljcg8D4IJ7oIF/0UEduwbsx3amAfDeg/9YtPRC4j5M0h3l7zLcJ2/BFwr8qYM74d0v00Hm4msirCPkE+kr58oL1NjwN7vvPA96HbSeBohH+f/X8FcZ965FhmjmZWgj0W",
      "serie_certificado": "30001000000400002335",
      "inicio_vigencia": "May 29 14:50:01 2019 GMT",
      "fin_vigencia": "May 29 14:50:01 2023 GMT",
      "password_key": "12345678a",
      "pem": "-----BEGIN PRIVATE KEY-----\nMIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQCr2Gk8lLr7VCMM\npoPPMUt0Yu1tie+fJbrBIMFGsXciMsS0Ctu9+sqyukaLYw7u6X286g+QsieoJE+9\nMdvUDXuTB1IHDT5wEaGCtvtGtJFo6cHjao29KQjjHr1As25Re9nOzJBK21uaqJSE\nSLCOFBUmTpSwyPTvZSptE5POQG9LImqlHnxpfZTjpIz0+z6/wpB5OI8WSTs2NnFl\nXstNL4BYf7fccWxekb4u9/HX2fUfYdk1RKWkUWG/puK6UzKLOhxH5obikrDXtvzP\nDQ8QuM5HMHQuVkvTYTXeJFEPu0xS5iKNeLTl10gWVVbIOPfy/pav3oeOCtWXt4kl\nvTOyIvJhAgMBAAECggEAFTEg+TmWPXxIvjyisKBxn667fPCvvj6W4044x5EHEg6U\nt2dHZgxRhuz12iajJs9glDWBKeTugwvHUZuecm4fOSiD8x6s/oEOG+KY5kVKUVfS\nc0smo5c141xdFmeKST4uxBPyD2kxyMbVWeLk8wCDAzBZoduGaSdergjmB19m2ir2\nfG1UgRxj3Q9q21IA40anqu8hICH6GNrNfjiJLHsF5X8I45/goV23VDvHRnIpS28/\nLeUbKO1SVcOeOFriLxtn65RS8KkiPOBlEkU06JZmhMdQvaJzDXHIzoSDCPErcS2z\nxzB8UR32Wb93fqFSJX1JOsoQWs8rQgKzXl8NS7moaQKBgQDitWkelQQzVh5hdEU3\n1JJx8wJcBiNbtutEi78cXCfRPKN2zmRjys1Vt6wxsz+X2e8e8mzo3ArsxXe8mTM2\nEd3/MfPq6129CCkf335ofX6VnuVsSk/p6pmj/D96avH7XGSizMtSVc5lHQSekYsL\n5I6lGMDqOelfgHOFGj0j+mP0owKBgQDCDFlJ3E0hpkDuJ+31hSUAwzFyPz7z3qvW\nWBIdI7RNeBHF8ZUKDujwe0B9XUGeSCezckiIEtLdiOopG5QXRY1N9hMXd96j7N2P\nT2Xg/a2sra7i/ZS1qYdzduqN3v/JIMmwQEHUy+Rp20r6ieV0vc9Tt9O2ImpgMpI1\nzfkyyhZpKwKBgCMSw8eKcFLs4Nhc35SKm3lrihLolDHNM8qwAAoIK9TQF836kkdq\nCahYORibTZxViAv2n2jLGhmVVzfjT6vuybSAaucOMLtc9tfKgMjzmVDWe1HskT50\nH/7huIRc5UDpA1y4aEA9rCeyfJN3mtZlLrhWAwp5mSRAQB74dzsIsswXAoGAGlBA\nX2KvVuvLjD//5bZLYUIW1246JCnC1YsV0bvAvGyWxGfRFQ8WiV29TgKyXjtcntnV\nehZLX90sG6zwtQMqeTLwPdN0bng1RzS2FP9xaKQYvhEy9Dtr8b1jax+dQfHfR7Y+\n9xM7AxvInBbM9bqzfZ/E5sLd9/ODniYzL671wQcCgYBRLjafty4Ui7/yNI+oxyog\ngXy3uRSu4Szqv8+oaUVzvPxndhEBQjBfx3VbCCGlDPYqMX7uJyIVXHQksIx9s0ds\nhEyjG5PZp2oIEq45gxiRnjmZczGGcPKSQM6/V+mD71RL2zbdc/KD6HeRfHhbNUgQ\nhYbyr8HWk5fWBA9ixLMyTA==\n-----END PRIVATE KEY-----\n",
      "fecha": "2023-05-25",
      "tipo": 0,
      "tipo_certificado": 1,
      "status": null,
      "url": null,
      "fecha_inicial": "2019-05-29 14:50:01",
      "fecha_final": "2023-05-29 14:50:01",
      "rfc_emisor": "AAA010101AAA"
    },
    {
      "id_cert_sello": 9175,
      "id_emisor": null,
      "cer": "MIIFgzCCA2ugAwIBAgIUMzAwMDEwMDAwMDA1MDAwMDMzNjIwDQYJKoZIhvcNAQELBQAwggErMQ8wDQYDVQQDDAZBQyBVQVQxLjAsBgNVBAoMJVNFUlZJQ0lPIERFIEFETUlOSVNUUkFDSU9OIFRSSUJVVEFSSUExGjAYBgNVBAsMEVNBVC1JRVMgQXV0aG9yaXR5MSgwJgYJKoZIhvcNAQkBFhlvc2Nhci5tYXJ0aW5lekBzYXQuZ29iLm14MR0wGwYDVQQJDBQzcmEgY2VycmFkYSBkZSBjYWxpejEOMAwGA1UEEQwFMDYzNzAxCzAJBgNVBAYTAk1YMRkwFwYDVQQIDBBDSVVEQUQgREUgTUVYSUNPMREwDwYDVQQHDAhDT1lPQUNBTjERMA8GA1UELRMIMi41LjQuNDUxJTAjBgkqhkiG9w0BCQITFnJlc3BvbnNhYmxlOiBBQ0RNQS1TQVQwHhcNMjMwNTE1MTY1NzU3WhcNMjcwNTE1MTY1NzU3WjCBqjEeMBwGA1UEAxMVTUFSSUEgV0FURU1CRVIgVE9SUkVTMR4wHAYDVQQpExVNQVJJQSBXQVRFTUJFUiBUT1JSRVMxHjAcBgNVBAoTFU1BUklBIFdBVEVNQkVSIFRPUlJFUzEWMBQGA1UELRMNV0FUTTY0MDkxN0o0NTEbMBkGA1UEBRMSV0FUTTY0MDkxN01IR1RSUjAxMRMwEQYDVQQLEwpTdWN1cnNhbCAxMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAueKA188y59jth2cxGI3IRAwKXA77p7bOOli5hb5Jsv3GdWdnrjg+hldmCnfV5OnfAj/oGKkD8UcpIEir1Yk9iz1CYN+p7uSndp0cwp6ExsCYY9GRC0FWPNY/ZXwc/CHOKW3Y2iXlWJDBfyhLCKC+4oTkBzp+2KmjRNIVdsJoVvZH/KSs6U7j+coos9ygrbvQk+i1UrC5L0/JhTA44Rp2l4Kj9sVhz1PUqA+Lq9rLMkvsDBC6NS3NlLhPsJ+4c5PlLTikc3LcLZVtBp/rz20pct+AAskGwDZe8/HVRecehb71pDaPCdHyj6j3Z3NJIArxLm6ecZZguWaSrA1LuSSOnQIDAQABox0wGzAMBgNVHRMBAf8EAjAAMAsGA1UdDwQEAwIGwDANBgkqhkiG9w0BAQsFAAOCAgEAdu2JXVqSJ/0nLLFIq+3bodv9dHgR8RraMTrMugBToKut69OEZ2+59rUzaYEOyfCnkoOcrpRikTH80QNvYyu4n2PaGuf6labBGloR8rkWgql96vB+xKTzhdF/kc9DwEYIWZgGAeamZ3X4CofJs10oYBUDCSdwOt4PPb9mDB7pKw6yH0M/OqLOFVCC7BAk4ER4pcuj5T/xBMLFcb09/cvUg/+/jETjHHrnS+BuBzXTvCUtLHBr6IOOmWAr8B8Onmph7FrJY/2lmZMLlGVY0POUa/4i+M8wntvfXxlyUoYc+5g4ZAdj2b6oj3gh2dDldkwV6K0ekPSChVcKqPgjsL9y7RfT+1miEwbEf+W5OeKE67MQoEtScJ7vuXXP1Gz/juUMyQY+BC/n2UmiLCTqAoXYybyTKiK1gV9Ymmxk1/LZUq6fvOuZoyOSgC0znlGg874BAwQ65WJwq34IOsN0grCC/pVPbLJpUUp9ZzDMMqAk6yC7UDHacQI7hO4b7TKn7vz150vp2ZJzjFwP3zUKBlF+VmWsMmpiINfguo/owVR4NYzy5RaZLkXbuiomU74VIsJySpo8SpUouvmkZjbMDbcsMD1rblXn+sCozz2altEP6DJYANqtbDy9hrWjIwTy0HbXR7Wg1ASz1fmV4YyPBks5otf0DomGmzLSEEHPaBNuDCU=",
      "serie_certificado": "30001000000500003362",
      "inicio_vigencia": "May 15 10:57:57 2023 CST",
      "fin_vigencia": "May 15 10:57:57 2027 CST",
      "password_key": "12345678a",
      "pem": "-----BEGIN PRIVATE KEY-----\nMIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQC54oDXzzLn2O2H\nZzEYjchEDApcDvunts46WLmFvkmy/cZ1Z2euOD6GV2YKd9Xk6d8CP+gYqQPxRykg\nSKvViT2LPUJg36nu5Kd2nRzCnoTGwJhj0ZELQVY81j9lfBz8Ic4pbdjaJeVYkMF/\nKEsIoL7ihOQHOn7YqaNE0hV2wmhW9kf8pKzpTuP5yiiz3KCtu9CT6LVSsLkvT8mF\nMDjhGnaXgqP2xWHPU9SoD4ur2ssyS+wMELo1Lc2UuE+wn7hzk+UtOKRzctwtlW0G\nn+vPbSly34ACyQbANl7z8dVF5x6FvvWkNo8J0fKPqPdnc0kgCvEubp5xlmC5ZpKs\nDUu5JI6dAgMBAAECggEAV9R0OIRIc1AGe7IAeq+TbsOZqYHS2p3/t4XwswcEX7SV\nLygazzD4KhXluxCAWlc+7hswGWbS3BBZmE1+E7lzAPWDBa7o5l3X2q3FxxeLeTXL\nS27b78uBaeF5twP71g5LETw7+GdrhHtxUhnBymPZjcJo1BmJkeoloQD671BQaLXK\n4AXmrpfariZqWb47f1Y7IvuA17Chp+oP2PtEOh6I5/YPqqgxmMYaigK3if+21sSK\n2a2GRYiOdNLW8qwgegi0w+0earHkimFnUCQtpCCX6IutYnyp52Ydz2ngzsx9l8Cd\neC5W5uGkioNN4SSV4v5ngCPmyjB6Zr0mesBHkbcYKQKBgQDsfSzwmtTpiDwhTuR5\nUX+ZGdFUnhB2bs5fdJ6gLltvlK84awDb2rh2Wx+GH2LHRSBRyxcNQB2Y+ilq9OXc\nAnYFNa7FeAr7aph9Xy7lDm6LneoLmCMylj5/eoDSagukwAheT7FS2Gwe8COCu8YX\nRzPyKSsb3F3HVMHqZcvD3ImmEwKBgQDJOIeA4NmRogH2hzT9VXEfV+jihdJl5jj2\nkHO5wVsvXfikTVobTS71eOzEpVNzfuRTlaTnpSmzjxbXEEG/KIm84EJfwJ+4cum+\nDhcl3mx0DpFOquILFxo82OV1zKbPkQzGLoJ/fm0n9o8Xi8L2OltEJVQejML4NQL9\n48FOCp1OjwKBgEer8DDDW/+i0EZv+IJkFr25u11fwjGCh30ahPCa3A9HCouYslvv\nP7RvDXDCllc6Nf9UA5p6cf3o4yCNNBSnkkkl6d/i78EenzRv4nB9HTenFkWJSDGO\no0ZTRDOA/CJkKKUcles7uBjwQnLeobxwUef0XiJFeQ5uO47kZwrnDbiNAoGAZbCL\nyjXXviGBnHT38o8bfBuRNekrSxPt9a1KzrVIv8ddwKrWvrVi5esWvMpQQi3+db9K\nd0agrH3DrSwqDdEOysUKxhkynqR0O/gi+qBNbtlt1bPGSJSETfvO+plSM9O6AO3A\nRW4++9M+vUeEX6teNDIpMMcyQP2JZYWUSzxSA0ECgYBOmUo+MDeY5dptG8hFNggK\nqYZlvzv7PtftqyWHnGZI5zg+SKOdYriAC9TUbl7r+Eh/psp/mZKmiBFt+miBInpe\nzwuKmBBZZDooZEwJQcrjBB6VIcljUXL27PjOWIGNE+SOefR6bNNSFaWYP0eofThR\ngkwuT6XOQ8PX8IKllkEZ3w==\n-----END PRIVATE KEY-----",
      "fecha": "2026-03-25",
      "tipo": 0,
      "tipo_certificado": 1,
      "status": null,
      "url": null,
      "fecha_inicial": "2023-05-15 10:57:57",
      "fecha_final": "2027-05-15 10:57:57",
      "rfc_emisor": "AAA010101AAA"
    },
    {
      "id_cert_sello": 9176,
      "id_emisor": null,
      "cer": "MIIFgzCCA2ugAwIBAgIUMzAwMDEwMDAwMDA1MDAwMDMzNjIwDQYJKoZIhvcNAQELBQAwggErMQ8wDQYDVQQDDAZBQyBVQVQxLjAsBgNVBAoMJVNFUlZJQ0lPIERFIEFETUlOSVNUUkFDSU9OIFRSSUJVVEFSSUExGjAYBgNVBAsMEVNBVC1JRVMgQXV0aG9yaXR5MSgwJgYJKoZIhvcNAQkBFhlvc2Nhci5tYXJ0aW5lekBzYXQuZ29iLm14MR0wGwYDVQQJDBQzcmEgY2VycmFkYSBkZSBjYWxpejEOMAwGA1UEEQwFMDYzNzAxCzAJBgNVBAYTAk1YMRkwFwYDVQQIDBBDSVVEQUQgREUgTUVYSUNPMREwDwYDVQQHDAhDT1lPQUNBTjERMA8GA1UELRMIMi41LjQuNDUxJTAjBgkqhkiG9w0BCQITFnJlc3BvbnNhYmxlOiBBQ0RNQS1TQVQwHhcNMjMwNTE1MTY1NzU3WhcNMjcwNTE1MTY1NzU3WjCBqjEeMBwGA1UEAxMVTUFSSUEgV0FURU1CRVIgVE9SUkVTMR4wHAYDVQQpExVNQVJJQSBXQVRFTUJFUiBUT1JSRVMxHjAcBgNVBAoTFU1BUklBIFdBVEVNQkVSIFRPUlJFUzEWMBQGA1UELRMNV0FUTTY0MDkxN0o0NTEbMBkGA1UEBRMSV0FUTTY0MDkxN01IR1RSUjAxMRMwEQYDVQQLEwpTdWN1cnNhbCAxMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAueKA188y59jth2cxGI3IRAwKXA77p7bOOli5hb5Jsv3GdWdnrjg+hldmCnfV5OnfAj/oGKkD8UcpIEir1Yk9iz1CYN+p7uSndp0cwp6ExsCYY9GRC0FWPNY/ZXwc/CHOKW3Y2iXlWJDBfyhLCKC+4oTkBzp+2KmjRNIVdsJoVvZH/KSs6U7j+coos9ygrbvQk+i1UrC5L0/JhTA44Rp2l4Kj9sVhz1PUqA+Lq9rLMkvsDBC6NS3NlLhPsJ+4c5PlLTikc3LcLZVtBp/rz20pct+AAskGwDZe8/HVRecehb71pDaPCdHyj6j3Z3NJIArxLm6ecZZguWaSrA1LuSSOnQIDAQABox0wGzAMBgNVHRMBAf8EAjAAMAsGA1UdDwQEAwIGwDANBgkqhkiG9w0BAQsFAAOCAgEAdu2JXVqSJ/0nLLFIq+3bodv9dHgR8RraMTrMugBToKut69OEZ2+59rUzaYEOyfCnkoOcrpRikTH80QNvYyu4n2PaGuf6labBGloR8rkWgql96vB+xKTzhdF/kc9DwEYIWZgGAeamZ3X4CofJs10oYBUDCSdwOt4PPb9mDB7pKw6yH0M/OqLOFVCC7BAk4ER4pcuj5T/xBMLFcb09/cvUg/+/jETjHHrnS+BuBzXTvCUtLHBr6IOOmWAr8B8Onmph7FrJY/2lmZMLlGVY0POUa/4i+M8wntvfXxlyUoYc+5g4ZAdj2b6oj3gh2dDldkwV6K0ekPSChVcKqPgjsL9y7RfT+1miEwbEf+W5OeKE67MQoEtScJ7vuXXP1Gz/juUMyQY+BC/n2UmiLCTqAoXYybyTKiK1gV9Ymmxk1/LZUq6fvOuZoyOSgC0znlGg874BAwQ65WJwq34IOsN0grCC/pVPbLJpUUp9ZzDMMqAk6yC7UDHacQI7hO4b7TKn7vz150vp2ZJzjFwP3zUKBlF+VmWsMmpiINfguo/owVR4NYzy5RaZLkXbuiomU74VIsJySpo8SpUouvmkZjbMDbcsMD1rblXn+sCozz2altEP6DJYANqtbDy9hrWjIwTy0HbXR7Wg1ASz1fmV4YyPBks5otf0DomGmzLSEEHPaBNuDCU=",
      "serie_certificado": "30001000000500003362",
      "inicio_vigencia": "May 15 10:57:57 2023 CST",
      "fin_vigencia": "May 15 10:57:57 2027 CST",
      "password_key": "12345678a",
      "pem": "-----BEGIN PRIVATE KEY-----\nMIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQC54oDXzzLn2O2H\nZzEYjchEDApcDvunts46WLmFvkmy/cZ1Z2euOD6GV2YKd9Xk6d8CP+gYqQPxRykg\nSKvViT2LPUJg36nu5Kd2nRzCnoTGwJhj0ZELQVY81j9lfBz8Ic4pbdjaJeVYkMF/\nKEsIoL7ihOQHOn7YqaNE0hV2wmhW9kf8pKzpTuP5yiiz3KCtu9CT6LVSsLkvT8mF\nMDjhGnaXgqP2xWHPU9SoD4ur2ssyS+wMELo1Lc2UuE+wn7hzk+UtOKRzctwtlW0G\nn+vPbSly34ACyQbANl7z8dVF5x6FvvWkNo8J0fKPqPdnc0kgCvEubp5xlmC5ZpKs\nDUu5JI6dAgMBAAECggEAV9R0OIRIc1AGe7IAeq+TbsOZqYHS2p3/t4XwswcEX7SV\nLygazzD4KhXluxCAWlc+7hswGWbS3BBZmE1+E7lzAPWDBa7o5l3X2q3FxxeLeTXL\nS27b78uBaeF5twP71g5LETw7+GdrhHtxUhnBymPZjcJo1BmJkeoloQD671BQaLXK\n4AXmrpfariZqWb47f1Y7IvuA17Chp+oP2PtEOh6I5/YPqqgxmMYaigK3if+21sSK\n2a2GRYiOdNLW8qwgegi0w+0earHkimFnUCQtpCCX6IutYnyp52Ydz2ngzsx9l8Cd\neC5W5uGkioNN4SSV4v5ngCPmyjB6Zr0mesBHkbcYKQKBgQDsfSzwmtTpiDwhTuR5\nUX+ZGdFUnhB2bs5fdJ6gLltvlK84awDb2rh2Wx+GH2LHRSBRyxcNQB2Y+ilq9OXc\nAnYFNa7FeAr7aph9Xy7lDm6LneoLmCMylj5/eoDSagukwAheT7FS2Gwe8COCu8YX\nRzPyKSsb3F3HVMHqZcvD3ImmEwKBgQDJOIeA4NmRogH2hzT9VXEfV+jihdJl5jj2\nkHO5wVsvXfikTVobTS71eOzEpVNzfuRTlaTnpSmzjxbXEEG/KIm84EJfwJ+4cum+\nDhcl3mx0DpFOquILFxo82OV1zKbPkQzGLoJ/fm0n9o8Xi8L2OltEJVQejML4NQL9\n48FOCp1OjwKBgEer8DDDW/+i0EZv+IJkFr25u11fwjGCh30ahPCa3A9HCouYslvv\nP7RvDXDCllc6Nf9UA5p6cf3o4yCNNBSnkkkl6d/i78EenzRv4nB9HTenFkWJSDGO\no0ZTRDOA/CJkKKUcles7uBjwQnLeobxwUef0XiJFeQ5uO47kZwrnDbiNAoGAZbCL\nyjXXviGBnHT38o8bfBuRNekrSxPt9a1KzrVIv8ddwKrWvrVi5esWvMpQQi3+db9K\nd0agrH3DrSwqDdEOysUKxhkynqR0O/gi+qBNbtlt1bPGSJSETfvO+plSM9O6AO3A\nRW4++9M+vUeEX6teNDIpMMcyQP2JZYWUSzxSA0ECgYBOmUo+MDeY5dptG8hFNggK\nqYZlvzv7PtftqyWHnGZI5zg+SKOdYriAC9TUbl7r+Eh/psp/mZKmiBFt+miBInpe\nzwuKmBBZZDooZEwJQcrjBB6VIcljUXL27PjOWIGNE+SOefR6bNNSFaWYP0eofThR\ngkwuT6XOQ8PX8IKllkEZ3w==\n-----END PRIVATE KEY-----",
      "fecha": "2026-03-25",
      "tipo": 0,
      "tipo_certificado": 1,
      "status": null,
      "url": null,
      "fecha_inicial": "2023-05-15 10:57:57",
      "fecha_final": "2027-05-15 10:57:57",
      "rfc_emisor": "AAA010101AAA"
    },
    {
      "id_cert_sello": 9177,
      "id_emisor": null,
      "cer": "MIIFgzCCA2ugAwIBAgIUMzAwMDEwMDAwMDA1MDAwMDMzNjIwDQYJKoZIhvcNAQELBQAwggErMQ8wDQYDVQQDDAZBQyBVQVQxLjAsBgNVBAoMJVNFUlZJQ0lPIERFIEFETUlOSVNUUkFDSU9OIFRSSUJVVEFSSUExGjAYBgNVBAsMEVNBVC1JRVMgQXV0aG9yaXR5MSgwJgYJKoZIhvcNAQkBFhlvc2Nhci5tYXJ0aW5lekBzYXQuZ29iLm14MR0wGwYDVQQJDBQzcmEgY2VycmFkYSBkZSBjYWxpejEOMAwGA1UEEQwFMDYzNzAxCzAJBgNVBAYTAk1YMRkwFwYDVQQIDBBDSVVEQUQgREUgTUVYSUNPMREwDwYDVQQHDAhDT1lPQUNBTjERMA8GA1UELRMIMi41LjQuNDUxJTAjBgkqhkiG9w0BCQITFnJlc3BvbnNhYmxlOiBBQ0RNQS1TQVQwHhcNMjMwNTE1MTY1NzU3WhcNMjcwNTE1MTY1NzU3WjCBqjEeMBwGA1UEAxMVTUFSSUEgV0FURU1CRVIgVE9SUkVTMR4wHAYDVQQpExVNQVJJQSBXQVRFTUJFUiBUT1JSRVMxHjAcBgNVBAoTFU1BUklBIFdBVEVNQkVSIFRPUlJFUzEWMBQGA1UELRMNV0FUTTY0MDkxN0o0NTEbMBkGA1UEBRMSV0FUTTY0MDkxN01IR1RSUjAxMRMwEQYDVQQLEwpTdWN1cnNhbCAxMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAueKA188y59jth2cxGI3IRAwKXA77p7bOOli5hb5Jsv3GdWdnrjg+hldmCnfV5OnfAj/oGKkD8UcpIEir1Yk9iz1CYN+p7uSndp0cwp6ExsCYY9GRC0FWPNY/ZXwc/CHOKW3Y2iXlWJDBfyhLCKC+4oTkBzp+2KmjRNIVdsJoVvZH/KSs6U7j+coos9ygrbvQk+i1UrC5L0/JhTA44Rp2l4Kj9sVhz1PUqA+Lq9rLMkvsDBC6NS3NlLhPsJ+4c5PlLTikc3LcLZVtBp/rz20pct+AAskGwDZe8/HVRecehb71pDaPCdHyj6j3Z3NJIArxLm6ecZZguWaSrA1LuSSOnQIDAQABox0wGzAMBgNVHRMBAf8EAjAAMAsGA1UdDwQEAwIGwDANBgkqhkiG9w0BAQsFAAOCAgEAdu2JXVqSJ/0nLLFIq+3bodv9dHgR8RraMTrMugBToKut69OEZ2+59rUzaYEOyfCnkoOcrpRikTH80QNvYyu4n2PaGuf6labBGloR8rkWgql96vB+xKTzhdF/kc9DwEYIWZgGAeamZ3X4CofJs10oYBUDCSdwOt4PPb9mDB7pKw6yH0M/OqLOFVCC7BAk4ER4pcuj5T/xBMLFcb09/cvUg/+/jETjHHrnS+BuBzXTvCUtLHBr6IOOmWAr8B8Onmph7FrJY/2lmZMLlGVY0POUa/4i+M8wntvfXxlyUoYc+5g4ZAdj2b6oj3gh2dDldkwV6K0ekPSChVcKqPgjsL9y7RfT+1miEwbEf+W5OeKE67MQoEtScJ7vuXXP1Gz/juUMyQY+BC/n2UmiLCTqAoXYybyTKiK1gV9Ymmxk1/LZUq6fvOuZoyOSgC0znlGg874BAwQ65WJwq34IOsN0grCC/pVPbLJpUUp9ZzDMMqAk6yC7UDHacQI7hO4b7TKn7vz150vp2ZJzjFwP3zUKBlF+VmWsMmpiINfguo/owVR4NYzy5RaZLkXbuiomU74VIsJySpo8SpUouvmkZjbMDbcsMD1rblXn+sCozz2altEP6DJYANqtbDy9hrWjIwTy0HbXR7Wg1ASz1fmV4YyPBks5otf0DomGmzLSEEHPaBNuDCU=",
      "serie_certificado": "30001000000500003362",
      "inicio_vigencia": "May 15 10:57:57 2023 CST",
      "fin_vigencia": "May 15 10:57:57 2027 CST",
      "password_key": "12345678a",
      "pem": "-----BEGIN PRIVATE KEY-----\nMIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQC54oDXzzLn2O2H\nZzEYjchEDApcDvunts46WLmFvkmy/cZ1Z2euOD6GV2YKd9Xk6d8CP+gYqQPxRykg\nSKvViT2LPUJg36nu5Kd2nRzCnoTGwJhj0ZELQVY81j9lfBz8Ic4pbdjaJeVYkMF/\nKEsIoL7ihOQHOn7YqaNE0hV2wmhW9kf8pKzpTuP5yiiz3KCtu9CT6LVSsLkvT8mF\nMDjhGnaXgqP2xWHPU9SoD4ur2ssyS+wMELo1Lc2UuE+wn7hzk+UtOKRzctwtlW0G\nn+vPbSly34ACyQbANl7z8dVF5x6FvvWkNo8J0fKPqPdnc0kgCvEubp5xlmC5ZpKs\nDUu5JI6dAgMBAAECggEAV9R0OIRIc1AGe7IAeq+TbsOZqYHS2p3/t4XwswcEX7SV\nLygazzD4KhXluxCAWlc+7hswGWbS3BBZmE1+E7lzAPWDBa7o5l3X2q3FxxeLeTXL\nS27b78uBaeF5twP71g5LETw7+GdrhHtxUhnBymPZjcJo1BmJkeoloQD671BQaLXK\n4AXmrpfariZqWb47f1Y7IvuA17Chp+oP2PtEOh6I5/YPqqgxmMYaigK3if+21sSK\n2a2GRYiOdNLW8qwgegi0w+0earHkimFnUCQtpCCX6IutYnyp52Ydz2ngzsx9l8Cd\neC5W5uGkioNN4SSV4v5ngCPmyjB6Zr0mesBHkbcYKQKBgQDsfSzwmtTpiDwhTuR5\nUX+ZGdFUnhB2bs5fdJ6gLltvlK84awDb2rh2Wx+GH2LHRSBRyxcNQB2Y+ilq9OXc\nAnYFNa7FeAr7aph9Xy7lDm6LneoLmCMylj5/eoDSagukwAheT7FS2Gwe8COCu8YX\nRzPyKSsb3F3HVMHqZcvD3ImmEwKBgQDJOIeA4NmRogH2hzT9VXEfV+jihdJl5jj2\nkHO5wVsvXfikTVobTS71eOzEpVNzfuRTlaTnpSmzjxbXEEG/KIm84EJfwJ+4cum+\nDhcl3mx0DpFOquILFxo82OV1zKbPkQzGLoJ/fm0n9o8Xi8L2OltEJVQejML4NQL9\n48FOCp1OjwKBgEer8DDDW/+i0EZv+IJkFr25u11fwjGCh30ahPCa3A9HCouYslvv\nP7RvDXDCllc6Nf9UA5p6cf3o4yCNNBSnkkkl6d/i78EenzRv4nB9HTenFkWJSDGO\no0ZTRDOA/CJkKKUcles7uBjwQnLeobxwUef0XiJFeQ5uO47kZwrnDbiNAoGAZbCL\nyjXXviGBnHT38o8bfBuRNekrSxPt9a1KzrVIv8ddwKrWvrVi5esWvMpQQi3+db9K\nd0agrH3DrSwqDdEOysUKxhkynqR0O/gi+qBNbtlt1bPGSJSETfvO+plSM9O6AO3A\nRW4++9M+vUeEX6teNDIpMMcyQP2JZYWUSzxSA0ECgYBOmUo+MDeY5dptG8hFNggK\nqYZlvzv7PtftqyWHnGZI5zg+SKOdYriAC9TUbl7r+Eh/psp/mZKmiBFt+miBInpe\nzwuKmBBZZDooZEwJQcrjBB6VIcljUXL27PjOWIGNE+SOefR6bNNSFaWYP0eofThR\ngkwuT6XOQ8PX8IKllkEZ3w==\n-----END PRIVATE KEY-----",
      "fecha": "2026-03-25",
      "tipo": 0,
      "tipo_certificado": 1,
      "status": null,
      "url": null,
      "fecha_inicial": "2023-05-15 10:57:57",
      "fecha_final": "2027-05-15 10:57:57",
      "rfc_emisor": "AAA010101AAA"
    },
    {
      "id_cert_sello": 9178,
      "id_emisor": null,
      "cer": "MIIFgzCCA2ugAwIBAgIUMzAwMDEwMDAwMDA1MDAwMDMzNjIwDQYJKoZIhvcNAQELBQAwggErMQ8wDQYDVQQDDAZBQyBVQVQxLjAsBgNVBAoMJVNFUlZJQ0lPIERFIEFETUlOSVNUUkFDSU9OIFRSSUJVVEFSSUExGjAYBgNVBAsMEVNBVC1JRVMgQXV0aG9yaXR5MSgwJgYJKoZIhvcNAQkBFhlvc2Nhci5tYXJ0aW5lekBzYXQuZ29iLm14MR0wGwYDVQQJDBQzcmEgY2VycmFkYSBkZSBjYWxpejEOMAwGA1UEEQwFMDYzNzAxCzAJBgNVBAYTAk1YMRkwFwYDVQQIDBBDSVVEQUQgREUgTUVYSUNPMREwDwYDVQQHDAhDT1lPQUNBTjERMA8GA1UELRMIMi41LjQuNDUxJTAjBgkqhkiG9w0BCQITFnJlc3BvbnNhYmxlOiBBQ0RNQS1TQVQwHhcNMjMwNTE1MTY1NzU3WhcNMjcwNTE1MTY1NzU3WjCBqjEeMBwGA1UEAxMVTUFSSUEgV0FURU1CRVIgVE9SUkVTMR4wHAYDVQQpExVNQVJJQSBXQVRFTUJFUiBUT1JSRVMxHjAcBgNVBAoTFU1BUklBIFdBVEVNQkVSIFRPUlJFUzEWMBQGA1UELRMNV0FUTTY0MDkxN0o0NTEbMBkGA1UEBRMSV0FUTTY0MDkxN01IR1RSUjAxMRMwEQYDVQQLEwpTdWN1cnNhbCAxMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAueKA188y59jth2cxGI3IRAwKXA77p7bOOli5hb5Jsv3GdWdnrjg+hldmCnfV5OnfAj/oGKkD8UcpIEir1Yk9iz1CYN+p7uSndp0cwp6ExsCYY9GRC0FWPNY/ZXwc/CHOKW3Y2iXlWJDBfyhLCKC+4oTkBzp+2KmjRNIVdsJoVvZH/KSs6U7j+coos9ygrbvQk+i1UrC5L0/JhTA44Rp2l4Kj9sVhz1PUqA+Lq9rLMkvsDBC6NS3NlLhPsJ+4c5PlLTikc3LcLZVtBp/rz20pct+AAskGwDZe8/HVRecehb71pDaPCdHyj6j3Z3NJIArxLm6ecZZguWaSrA1LuSSOnQIDAQABox0wGzAMBgNVHRMBAf8EAjAAMAsGA1UdDwQEAwIGwDANBgkqhkiG9w0BAQsFAAOCAgEAdu2JXVqSJ/0nLLFIq+3bodv9dHgR8RraMTrMugBToKut69OEZ2+59rUzaYEOyfCnkoOcrpRikTH80QNvYyu4n2PaGuf6labBGloR8rkWgql96vB+xKTzhdF/kc9DwEYIWZgGAeamZ3X4CofJs10oYBUDCSdwOt4PPb9mDB7pKw6yH0M/OqLOFVCC7BAk4ER4pcuj5T/xBMLFcb09/cvUg/+/jETjHHrnS+BuBzXTvCUtLHBr6IOOmWAr8B8Onmph7FrJY/2lmZMLlGVY0POUa/4i+M8wntvfXxlyUoYc+5g4ZAdj2b6oj3gh2dDldkwV6K0ekPSChVcKqPgjsL9y7RfT+1miEwbEf+W5OeKE67MQoEtScJ7vuXXP1Gz/juUMyQY+BC/n2UmiLCTqAoXYybyTKiK1gV9Ymmxk1/LZUq6fvOuZoyOSgC0znlGg874BAwQ65WJwq34IOsN0grCC/pVPbLJpUUp9ZzDMMqAk6yC7UDHacQI7hO4b7TKn7vz150vp2ZJzjFwP3zUKBlF+VmWsMmpiINfguo/owVR4NYzy5RaZLkXbuiomU74VIsJySpo8SpUouvmkZjbMDbcsMD1rblXn+sCozz2altEP6DJYANqtbDy9hrWjIwTy0HbXR7Wg1ASz1fmV4YyPBks5otf0DomGmzLSEEHPaBNuDCU=",
      "serie_certificado": "30001000000500003362",
      "inicio_vigencia": "May 15 10:57:57 2023 CST",
      "fin_vigencia": "May 15 10:57:57 2027 CST",
      "password_key": "12345678a",
      "pem": "-----BEGIN PRIVATE KEY-----\nMIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQC54oDXzzLn2O2H\nZzEYjchEDApcDvunts46WLmFvkmy/cZ1Z2euOD6GV2YKd9Xk6d8CP+gYqQPxRykg\nSKvViT2LPUJg36nu5Kd2nRzCnoTGwJhj0ZELQVY81j9lfBz8Ic4pbdjaJeVYkMF/\nKEsIoL7ihOQHOn7YqaNE0hV2wmhW9kf8pKzpTuP5yiiz3KCtu9CT6LVSsLkvT8mF\nMDjhGnaXgqP2xWHPU9SoD4ur2ssyS+wMELo1Lc2UuE+wn7hzk+UtOKRzctwtlW0G\nn+vPbSly34ACyQbANl7z8dVF5x6FvvWkNo8J0fKPqPdnc0kgCvEubp5xlmC5ZpKs\nDUu5JI6dAgMBAAECggEAV9R0OIRIc1AGe7IAeq+TbsOZqYHS2p3/t4XwswcEX7SV\nLygazzD4KhXluxCAWlc+7hswGWbS3BBZmE1+E7lzAPWDBa7o5l3X2q3FxxeLeTXL\nS27b78uBaeF5twP71g5LETw7+GdrhHtxUhnBymPZjcJo1BmJkeoloQD671BQaLXK\n4AXmrpfariZqWb47f1Y7IvuA17Chp+oP2PtEOh6I5/YPqqgxmMYaigK3if+21sSK\n2a2GRYiOdNLW8qwgegi0w+0earHkimFnUCQtpCCX6IutYnyp52Ydz2ngzsx9l8Cd\neC5W5uGkioNN4SSV4v5ngCPmyjB6Zr0mesBHkbcYKQKBgQDsfSzwmtTpiDwhTuR5\nUX+ZGdFUnhB2bs5fdJ6gLltvlK84awDb2rh2Wx+GH2LHRSBRyxcNQB2Y+ilq9OXc\nAnYFNa7FeAr7aph9Xy7lDm6LneoLmCMylj5/eoDSagukwAheT7FS2Gwe8COCu8YX\nRzPyKSsb3F3HVMHqZcvD3ImmEwKBgQDJOIeA4NmRogH2hzT9VXEfV+jihdJl5jj2\nkHO5wVsvXfikTVobTS71eOzEpVNzfuRTlaTnpSmzjxbXEEG/KIm84EJfwJ+4cum+\nDhcl3mx0DpFOquILFxo82OV1zKbPkQzGLoJ/fm0n9o8Xi8L2OltEJVQejML4NQL9\n48FOCp1OjwKBgEer8DDDW/+i0EZv+IJkFr25u11fwjGCh30ahPCa3A9HCouYslvv\nP7RvDXDCllc6Nf9UA5p6cf3o4yCNNBSnkkkl6d/i78EenzRv4nB9HTenFkWJSDGO\no0ZTRDOA/CJkKKUcles7uBjwQnLeobxwUef0XiJFeQ5uO47kZwrnDbiNAoGAZbCL\nyjXXviGBnHT38o8bfBuRNekrSxPt9a1KzrVIv8ddwKrWvrVi5esWvMpQQi3+db9K\nd0agrH3DrSwqDdEOysUKxhkynqR0O/gi+qBNbtlt1bPGSJSETfvO+plSM9O6AO3A\nRW4++9M+vUeEX6teNDIpMMcyQP2JZYWUSzxSA0ECgYBOmUo+MDeY5dptG8hFNggK\nqYZlvzv7PtftqyWHnGZI5zg+SKOdYriAC9TUbl7r+Eh/psp/mZKmiBFt+miBInpe\nzwuKmBBZZDooZEwJQcrjBB6VIcljUXL27PjOWIGNE+SOefR6bNNSFaWYP0eofThR\ngkwuT6XOQ8PX8IKllkEZ3w==\n-----END PRIVATE KEY-----",
      "fecha": "2026-03-25",
      "tipo": 0,
      "tipo_certificado": 1,
      "status": null,
      "url": null,
      "fecha_inicial": "2023-05-15 10:57:57",
      "fecha_final": "2027-05-15 10:57:57",
      "rfc_emisor": "AAA010101AAA"
    },
    {
      "id_cert_sello": 9179,
      "id_emisor": null,
      "cer": "MIIFgzCCA2ugAwIBAgIUMzAwMDEwMDAwMDA1MDAwMDMzNjIwDQYJKoZIhvcNAQELBQAwggErMQ8wDQYDVQQDDAZBQyBVQVQxLjAsBgNVBAoMJVNFUlZJQ0lPIERFIEFETUlOSVNUUkFDSU9OIFRSSUJVVEFSSUExGjAYBgNVBAsMEVNBVC1JRVMgQXV0aG9yaXR5MSgwJgYJKoZIhvcNAQkBFhlvc2Nhci5tYXJ0aW5lekBzYXQuZ29iLm14MR0wGwYDVQQJDBQzcmEgY2VycmFkYSBkZSBjYWxpejEOMAwGA1UEEQwFMDYzNzAxCzAJBgNVBAYTAk1YMRkwFwYDVQQIDBBDSVVEQUQgREUgTUVYSUNPMREwDwYDVQQHDAhDT1lPQUNBTjERMA8GA1UELRMIMi41LjQuNDUxJTAjBgkqhkiG9w0BCQITFnJlc3BvbnNhYmxlOiBBQ0RNQS1TQVQwHhcNMjMwNTE1MTY1NzU3WhcNMjcwNTE1MTY1NzU3WjCBqjEeMBwGA1UEAxMVTUFSSUEgV0FURU1CRVIgVE9SUkVTMR4wHAYDVQQpExVNQVJJQSBXQVRFTUJFUiBUT1JSRVMxHjAcBgNVBAoTFU1BUklBIFdBVEVNQkVSIFRPUlJFUzEWMBQGA1UELRMNV0FUTTY0MDkxN0o0NTEbMBkGA1UEBRMSV0FUTTY0MDkxN01IR1RSUjAxMRMwEQYDVQQLEwpTdWN1cnNhbCAxMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAueKA188y59jth2cxGI3IRAwKXA77p7bOOli5hb5Jsv3GdWdnrjg+hldmCnfV5OnfAj/oGKkD8UcpIEir1Yk9iz1CYN+p7uSndp0cwp6ExsCYY9GRC0FWPNY/ZXwc/CHOKW3Y2iXlWJDBfyhLCKC+4oTkBzp+2KmjRNIVdsJoVvZH/KSs6U7j+coos9ygrbvQk+i1UrC5L0/JhTA44Rp2l4Kj9sVhz1PUqA+Lq9rLMkvsDBC6NS3NlLhPsJ+4c5PlLTikc3LcLZVtBp/rz20pct+AAskGwDZe8/HVRecehb71pDaPCdHyj6j3Z3NJIArxLm6ecZZguWaSrA1LuSSOnQIDAQABox0wGzAMBgNVHRMBAf8EAjAAMAsGA1UdDwQEAwIGwDANBgkqhkiG9w0BAQsFAAOCAgEAdu2JXVqSJ/0nLLFIq+3bodv9dHgR8RraMTrMugBToKut69OEZ2+59rUzaYEOyfCnkoOcrpRikTH80QNvYyu4n2PaGuf6labBGloR8rkWgql96vB+xKTzhdF/kc9DwEYIWZgGAeamZ3X4CofJs10oYBUDCSdwOt4PPb9mDB7pKw6yH0M/OqLOFVCC7BAk4ER4pcuj5T/xBMLFcb09/cvUg/+/jETjHHrnS+BuBzXTvCUtLHBr6IOOmWAr8B8Onmph7FrJY/2lmZMLlGVY0POUa/4i+M8wntvfXxlyUoYc+5g4ZAdj2b6oj3gh2dDldkwV6K0ekPSChVcKqPgjsL9y7RfT+1miEwbEf+W5OeKE67MQoEtScJ7vuXXP1Gz/juUMyQY+BC/n2UmiLCTqAoXYybyTKiK1gV9Ymmxk1/LZUq6fvOuZoyOSgC0znlGg874BAwQ65WJwq34IOsN0grCC/pVPbLJpUUp9ZzDMMqAk6yC7UDHacQI7hO4b7TKn7vz150vp2ZJzjFwP3zUKBlF+VmWsMmpiINfguo/owVR4NYzy5RaZLkXbuiomU74VIsJySpo8SpUouvmkZjbMDbcsMD1rblXn+sCozz2altEP6DJYANqtbDy9hrWjIwTy0HbXR7Wg1ASz1fmV4YyPBks5otf0DomGmzLSEEHPaBNuDCU=",
      "serie_certificado": "30001000000500003362",
      "inicio_vigencia": "May 15 10:57:57 2023 CST",
      "fin_vigencia": "May 15 10:57:57 2027 CST",
      "password_key": "12345678a",
      "pem": "-----BEGIN PRIVATE KEY-----\nMIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQC54oDXzzLn2O2H\nZzEYjchEDApcDvunts46WLmFvkmy/cZ1Z2euOD6GV2YKd9Xk6d8CP+gYqQPxRykg\nSKvViT2LPUJg36nu5Kd2nRzCnoTGwJhj0ZELQVY81j9lfBz8Ic4pbdjaJeVYkMF/\nKEsIoL7ihOQHOn7YqaNE0hV2wmhW9kf8pKzpTuP5yiiz3KCtu9CT6LVSsLkvT8mF\nMDjhGnaXgqP2xWHPU9SoD4ur2ssyS+wMELo1Lc2UuE+wn7hzk+UtOKRzctwtlW0G\nn+vPbSly34ACyQbANl7z8dVF5x6FvvWkNo8J0fKPqPdnc0kgCvEubp5xlmC5ZpKs\nDUu5JI6dAgMBAAECggEAV9R0OIRIc1AGe7IAeq+TbsOZqYHS2p3/t4XwswcEX7SV\nLygazzD4KhXluxCAWlc+7hswGWbS3BBZmE1+E7lzAPWDBa7o5l3X2q3FxxeLeTXL\nS27b78uBaeF5twP71g5LETw7+GdrhHtxUhnBymPZjcJo1BmJkeoloQD671BQaLXK\n4AXmrpfariZqWb47f1Y7IvuA17Chp+oP2PtEOh6I5/YPqqgxmMYaigK3if+21sSK\n2a2GRYiOdNLW8qwgegi0w+0earHkimFnUCQtpCCX6IutYnyp52Ydz2ngzsx9l8Cd\neC5W5uGkioNN4SSV4v5ngCPmyjB6Zr0mesBHkbcYKQKBgQDsfSzwmtTpiDwhTuR5\nUX+ZGdFUnhB2bs5fdJ6gLltvlK84awDb2rh2Wx+GH2LHRSBRyxcNQB2Y+ilq9OXc\nAnYFNa7FeAr7aph9Xy7lDm6LneoLmCMylj5/eoDSagukwAheT7FS2Gwe8COCu8YX\nRzPyKSsb3F3HVMHqZcvD3ImmEwKBgQDJOIeA4NmRogH2hzT9VXEfV+jihdJl5jj2\nkHO5wVsvXfikTVobTS71eOzEpVNzfuRTlaTnpSmzjxbXEEG/KIm84EJfwJ+4cum+\nDhcl3mx0DpFOquILFxo82OV1zKbPkQzGLoJ/fm0n9o8Xi8L2OltEJVQejML4NQL9\n48FOCp1OjwKBgEer8DDDW/+i0EZv+IJkFr25u11fwjGCh30ahPCa3A9HCouYslvv\nP7RvDXDCllc6Nf9UA5p6cf3o4yCNNBSnkkkl6d/i78EenzRv4nB9HTenFkWJSDGO\no0ZTRDOA/CJkKKUcles7uBjwQnLeobxwUef0XiJFeQ5uO47kZwrnDbiNAoGAZbCL\nyjXXviGBnHT38o8bfBuRNekrSxPt9a1KzrVIv8ddwKrWvrVi5esWvMpQQi3+db9K\nd0agrH3DrSwqDdEOysUKxhkynqR0O/gi+qBNbtlt1bPGSJSETfvO+plSM9O6AO3A\nRW4++9M+vUeEX6teNDIpMMcyQP2JZYWUSzxSA0ECgYBOmUo+MDeY5dptG8hFNggK\nqYZlvzv7PtftqyWHnGZI5zg+SKOdYriAC9TUbl7r+Eh/psp/mZKmiBFt+miBInpe\nzwuKmBBZZDooZEwJQcrjBB6VIcljUXL27PjOWIGNE+SOefR6bNNSFaWYP0eofThR\ngkwuT6XOQ8PX8IKllkEZ3w==\n-----END PRIVATE KEY-----",
      "fecha": "2026-03-25",
      "tipo": 0,
      "tipo_certificado": 1,
      "status": null,
      "url": null,
      "fecha_inicial": "2023-05-15 10:57:57",
      "fecha_final": "2027-05-15 10:57:57",
      "rfc_emisor": "AAA010101AAA"
    },
    {
      "id_cert_sello": 9180,
      "id_emisor": null,
      "cer": "MIIFgzCCA2ugAwIBAgIUMzAwMDEwMDAwMDA1MDAwMDMzNjIwDQYJKoZIhvcNAQELBQAwggErMQ8wDQYDVQQDDAZBQyBVQVQxLjAsBgNVBAoMJVNFUlZJQ0lPIERFIEFETUlOSVNUUkFDSU9OIFRSSUJVVEFSSUExGjAYBgNVBAsMEVNBVC1JRVMgQXV0aG9yaXR5MSgwJgYJKoZIhvcNAQkBFhlvc2Nhci5tYXJ0aW5lekBzYXQuZ29iLm14MR0wGwYDVQQJDBQzcmEgY2VycmFkYSBkZSBjYWxpejEOMAwGA1UEEQwFMDYzNzAxCzAJBgNVBAYTAk1YMRkwFwYDVQQIDBBDSVVEQUQgREUgTUVYSUNPMREwDwYDVQQHDAhDT1lPQUNBTjERMA8GA1UELRMIMi41LjQuNDUxJTAjBgkqhkiG9w0BCQITFnJlc3BvbnNhYmxlOiBBQ0RNQS1TQVQwHhcNMjMwNTE1MTY1NzU3WhcNMjcwNTE1MTY1NzU3WjCBqjEeMBwGA1UEAxMVTUFSSUEgV0FURU1CRVIgVE9SUkVTMR4wHAYDVQQpExVNQVJJQSBXQVRFTUJFUiBUT1JSRVMxHjAcBgNVBAoTFU1BUklBIFdBVEVNQkVSIFRPUlJFUzEWMBQGA1UELRMNV0FUTTY0MDkxN0o0NTEbMBkGA1UEBRMSV0FUTTY0MDkxN01IR1RSUjAxMRMwEQYDVQQLEwpTdWN1cnNhbCAxMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAueKA188y59jth2cxGI3IRAwKXA77p7bOOli5hb5Jsv3GdWdnrjg+hldmCnfV5OnfAj/oGKkD8UcpIEir1Yk9iz1CYN+p7uSndp0cwp6ExsCYY9GRC0FWPNY/ZXwc/CHOKW3Y2iXlWJDBfyhLCKC+4oTkBzp+2KmjRNIVdsJoVvZH/KSs6U7j+coos9ygrbvQk+i1UrC5L0/JhTA44Rp2l4Kj9sVhz1PUqA+Lq9rLMkvsDBC6NS3NlLhPsJ+4c5PlLTikc3LcLZVtBp/rz20pct+AAskGwDZe8/HVRecehb71pDaPCdHyj6j3Z3NJIArxLm6ecZZguWaSrA1LuSSOnQIDAQABox0wGzAMBgNVHRMBAf8EAjAAMAsGA1UdDwQEAwIGwDANBgkqhkiG9w0BAQsFAAOCAgEAdu2JXVqSJ/0nLLFIq+3bodv9dHgR8RraMTrMugBToKut69OEZ2+59rUzaYEOyfCnkoOcrpRikTH80QNvYyu4n2PaGuf6labBGloR8rkWgql96vB+xKTzhdF/kc9DwEYIWZgGAeamZ3X4CofJs10oYBUDCSdwOt4PPb9mDB7pKw6yH0M/OqLOFVCC7BAk4ER4pcuj5T/xBMLFcb09/cvUg/+/jETjHHrnS+BuBzXTvCUtLHBr6IOOmWAr8B8Onmph7FrJY/2lmZMLlGVY0POUa/4i+M8wntvfXxlyUoYc+5g4ZAdj2b6oj3gh2dDldkwV6K0ekPSChVcKqPgjsL9y7RfT+1miEwbEf+W5OeKE67MQoEtScJ7vuXXP1Gz/juUMyQY+BC/n2UmiLCTqAoXYybyTKiK1gV9Ymmxk1/LZUq6fvOuZoyOSgC0znlGg874BAwQ65WJwq34IOsN0grCC/pVPbLJpUUp9ZzDMMqAk6yC7UDHacQI7hO4b7TKn7vz150vp2ZJzjFwP3zUKBlF+VmWsMmpiINfguo/owVR4NYzy5RaZLkXbuiomU74VIsJySpo8SpUouvmkZjbMDbcsMD1rblXn+sCozz2altEP6DJYANqtbDy9hrWjIwTy0HbXR7Wg1ASz1fmV4YyPBks5otf0DomGmzLSEEHPaBNuDCU=",
      "serie_certificado": "30001000000500003362",
      "inicio_vigencia": "May 15 10:57:57 2023 CST",
      "fin_vigencia": "May 15 10:57:57 2027 CST",
      "password_key": "12345678a",
      "pem": "-----BEGIN PRIVATE KEY-----\nMIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQC54oDXzzLn2O2H\nZzEYjchEDApcDvunts46WLmFvkmy/cZ1Z2euOD6GV2YKd9Xk6d8CP+gYqQPxRykg\nSKvViT2LPUJg36nu5Kd2nRzCnoTGwJhj0ZELQVY81j9lfBz8Ic4pbdjaJeVYkMF/\nKEsIoL7ihOQHOn7YqaNE0hV2wmhW9kf8pKzpTuP5yiiz3KCtu9CT6LVSsLkvT8mF\nMDjhGnaXgqP2xWHPU9SoD4ur2ssyS+wMELo1Lc2UuE+wn7hzk+UtOKRzctwtlW0G\nn+vPbSly34ACyQbANl7z8dVF5x6FvvWkNo8J0fKPqPdnc0kgCvEubp5xlmC5ZpKs\nDUu5JI6dAgMBAAECggEAV9R0OIRIc1AGe7IAeq+TbsOZqYHS2p3/t4XwswcEX7SV\nLygazzD4KhXluxCAWlc+7hswGWbS3BBZmE1+E7lzAPWDBa7o5l3X2q3FxxeLeTXL\nS27b78uBaeF5twP71g5LETw7+GdrhHtxUhnBymPZjcJo1BmJkeoloQD671BQaLXK\n4AXmrpfariZqWb47f1Y7IvuA17Chp+oP2PtEOh6I5/YPqqgxmMYaigK3if+21sSK\n2a2GRYiOdNLW8qwgegi0w+0earHkimFnUCQtpCCX6IutYnyp52Ydz2ngzsx9l8Cd\neC5W5uGkioNN4SSV4v5ngCPmyjB6Zr0mesBHkbcYKQKBgQDsfSzwmtTpiDwhTuR5\nUX+ZGdFUnhB2bs5fdJ6gLltvlK84awDb2rh2Wx+GH2LHRSBRyxcNQB2Y+ilq9OXc\nAnYFNa7FeAr7aph9Xy7lDm6LneoLmCMylj5/eoDSagukwAheT7FS2Gwe8COCu8YX\nRzPyKSsb3F3HVMHqZcvD3ImmEwKBgQDJOIeA4NmRogH2hzT9VXEfV+jihdJl5jj2\nkHO5wVsvXfikTVobTS71eOzEpVNzfuRTlaTnpSmzjxbXEEG/KIm84EJfwJ+4cum+\nDhcl3mx0DpFOquILFxo82OV1zKbPkQzGLoJ/fm0n9o8Xi8L2OltEJVQejML4NQL9\n48FOCp1OjwKBgEer8DDDW/+i0EZv+IJkFr25u11fwjGCh30ahPCa3A9HCouYslvv\nP7RvDXDCllc6Nf9UA5p6cf3o4yCNNBSnkkkl6d/i78EenzRv4nB9HTenFkWJSDGO\no0ZTRDOA/CJkKKUcles7uBjwQnLeobxwUef0XiJFeQ5uO47kZwrnDbiNAoGAZbCL\nyjXXviGBnHT38o8bfBuRNekrSxPt9a1KzrVIv8ddwKrWvrVi5esWvMpQQi3+db9K\nd0agrH3DrSwqDdEOysUKxhkynqR0O/gi+qBNbtlt1bPGSJSETfvO+plSM9O6AO3A\nRW4++9M+vUeEX6teNDIpMMcyQP2JZYWUSzxSA0ECgYBOmUo+MDeY5dptG8hFNggK\nqYZlvzv7PtftqyWHnGZI5zg+SKOdYriAC9TUbl7r+Eh/psp/mZKmiBFt+miBInpe\nzwuKmBBZZDooZEwJQcrjBB6VIcljUXL27PjOWIGNE+SOefR6bNNSFaWYP0eofThR\ngkwuT6XOQ8PX8IKllkEZ3w==\n-----END PRIVATE KEY-----",
      "fecha": "2026-03-25",
      "tipo": 0,
      "tipo_certificado": 1,
      "status": null,
      "url": null,
      "fecha_inicial": "2023-05-15 10:57:57",
      "fecha_final": "2027-05-15 10:57:57",
      "rfc_emisor": "AAA010101AAA"
    }
  ],
  "pagination": {
    "current_page": 1,
    "per_page": 15,
    "total": 7,
    "last_page": 1,
    "next_page_url": null,
    "prev_page_url": null
  }
}
```

**Certificados**

Para agregar certificados al emisor padre se utilizan el endpoint `{{ url }}/certificados` y se comporta igual al endpoint de los certificados para emisores hijos

**Series**

Para agregar Series al emisor padre se utilizan el endpoint `{{ url }}/series` y se comporta igual al endpoint de las series para emisores hijos