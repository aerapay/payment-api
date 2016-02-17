# Checkout with Aerapay

The Aerapay Checkout method enables merchants to receive payments within the Aerapay platform and gives customers additional payment methods. Online shoppers can pay using their Aerapay balance or load funds using their debit/credit card. The following depicts the integration for your e-Commerce system.

###### In the Aerapay Checkout flow, the buyer:

1. Can choose Aerapay Checkout by selecting Checkout with Aerapay
2. Logs into Aerapay and authenticates his or her identity
3. Selects a payment method and reviews the transaction within Aerapay
4. Confirms the order and pays from your site
5. Receives an order confirmation

###### Uinsg the Aerapay Checkout, on the merchant's web application:

1. Submit all payment details to Aerapay via `POST` to `/checkout` and receives a payment token
2. Redirects the buyer to the Aerapay checkout page
3. Recieves the result, and if successful payment and payer information
4. Updates the payment details optionally via `POST` to `/update`
5. Completes the payment via `POST` to `/complete`

Environment | URL
------|------------
Live | contact Aerapay for the URL
Test | https://payment2test.aerapay.com/

## Authentication

Aerapay will provide an `API_ID` and an `API_SECRET` to sign the API requests.

Attach the following custom headers to your API calls

Custom Header | Value
------|------------
API_ID | Your `API_ID`
API_SIGNATURE | SHA256( JSON_STRING( REQUEST_BODY ) + `API_SECRET` )

## 1. Submit thepayment details

#### POST /checkout

__Request__

Field | Type | Required | Description
------|------------|------------|------------
redirect | *String* | Yes | Redirect url for the payment result
merchant | *Object* | No | 
merchant.name | *String* | No | Name of the merchant
merchant.email | *String* | No | Support email address 
merchant.website | *String* | No | URL of the merchant's website 
merchant.image | *String* | No | URL to the merchant's logo
order | *Object* | Yes | 
order.currency | *String* | Yes | **Currencies**
order.total | *String* | Yes | Total amount of the order
order.shipping | *String* | No | Total shipping costs 
order.items | *Array* | No | 
order.items[n].id | *String* | No | Identifier of the item
order.items[n].name | *String* | No | Name of the item
order.items[n].amount | *String* | No | Amount of the item
order.items[n].quantity | *String* | No | Number of items
attachment | *Object* | No | Will be attached to each direct or indirect response

__Response__

Field | Type | Description
------|------------|------------
token | *String* | Token to identitfy and access payment
result | *Object* | 
result.code | *Number* | **Result codes**
result.message | *String* | Detailed message
attachment | *Object* | Your defined attachment

__Result Codes__

Code | Description
------|------------
13 | Authentication failed
20 | Payment approved
31 | Payment rejected
44 | Validation error
57 | Invalid total

__Currencies__

Code | Description
------|------------
USD | US Dollars
EUR | Euro

## 2. Redirect to checkout page

Once your payment got approved, build the checkout URL and redirect the buyer to the Aerapay checkout page.

https://`AERAPAY_ENVIRONMENT`/?token=`TOKEN`

## 3. Confirmed payment, redirect to the result URL

Attached is a base64 encoded JSON String as URL parameter named „result“. Decode and parse.

Field | Type | Description
------|------------|------------
token | *String* | Token to identitfy and access payment
result.code | *Number* | Result code
result.message | *String* | Detailed message
payment | *Object* | 
payment.id | *Object* | Identifier of the payment
payment.status | *String* | **Payment Status**
payment.method | *String* | **Payment Method**
payment.currency | *String* | **Currencies**
payment.total | *String* | Total amount of the payment
payment.shipping | *String* | Total shipping costs
payment.fee | *String* | Total fees for the merchant
payer | *Object* | 
payer.id | *String* | Aerapay account number
payer.username | *String* | Aerapay username
payer.first_name | *String* | First name
payer.last_name | *String* | Last name
payer.address | *Object* | 
payer.address.street | *String* | street name
payer.address.postal | *String* | postal code
payer.address.city | *String* | city
payer.address.state | *String* | state 
payer.address.country | *String* | country 
payer.nationality | *String* | Nationality of the payer
attachment | *Object* | Your defined attachment

## 4. Update your payment (optional)

You...

## 5. Complete your payment

You...
