# Checkout with Aerapay

The Aerapay Checkout method enables merchants to receive payments within the Aerapay platform and gives customers additional payment methods. Online shoppers can pay using their Aerapay balance or load funds using their debit/credit card. The following depicts the integration for your e-Commerce system.

###### In the Aerapay Checkout flow, the buyer:

1. Can choose Aerapay Checkout by selecting Checkout with Aerapay
2. Logs into Aerapay and authenticates his or her identity
3. Selects a payment method and reviews the transaction within Aerapay
4. Confirms the order and pays from your site

###### Using the Aerapay Checkout, on the merchant's web application:

1. Submit all payment details to Aerapay via `POST` to `/checkout` and receives a payment token
2. Redirect the buyer to the Aerapay checkout page
3. Recieve the result, and if successful payment and payer information
4. Complete the payment via `POST` to `/complete`

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
API_SIGNATURE | sha256( ( REQUEST_BODY as JSON-String ) + `API_SECRET` ) as Base64

## 1. Submit the payment details

#### POST /checkout
**Content-Type:** application/json

__Request__

Field | Type | Required | Description
------|------------|------------|------------
redirect | *String* | Yes | Redirect url for the payment result
notificationUrl | *String* | No | Url for payment status notifications
merchant | *Object* | No | 
merchant.name | *String* | No | Name of the merchant
merchant.email | *String* | No | Support email address 
merchant.website | *String* | No | URL of the merchant's website 
merchant.image | *String* | No | URL to the merchant's logo
order | *Object* | Yes | 
order.currency | *String* | Yes | *Currencies* (1)
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
result.code | *Number* | *Result codes* (2)
result.message | *String* | Detailed message
payment | *Object* | 
payment.id | *Object* | Identifier of the payment
payment.status | *String* | *Payment status* (3)
payment.currency | *String* | *Currencies* (1)
payment.total | *String* | Total amount of the payment
attachment | *Object* | Your defined attachment

__(2) Result Codes__

Code | Description | HTTP Status
------|------------|------------
13 | Authentication failed | 400
20 | Payment approved | 200
23 | Payment rejected | 400
44 | Validation error | 400
57 | Order total invalid | 400

## 2. Redirect to checkout page

Once your payment got approved, build the checkout URL and redirect the buyer to the Aerapay checkout page.

https://`AERAPAY_ENVIRONMENT`/?token=`TOKEN`

## 3. Confirmed payment, redirect to the result URL

Attached is a base64 encoded JSON String as URL parameter named „result“. Decode and parse.

Field | Type | Description
------|------------|------------
token | *String* | Token to identitfy and access payment
result.code | *Number* | *Result codes* (4)
result.message | *String* | Detailed message
payment | *Object* | 
payment.id | *Object* | Identifier of the payment
payment.status | *String* | *Payment status* (3)
payment.method | *String* | *Payment methods* (5)
payment.currency | *String* | *Currencies* (1)
payment.total | *String* | Total amount of the payment
payment.fee | *String* | Total fees for the merchant
payer | *Object* | 
payer.id | *String* | Aerapay account number
payer.username | *String* | Aerapay username
payer.first_name | *String* | First name
payer.last_name | *String* | Last name
payer.account_type | *String* | *Account types* (7)
payer.email | *String* | Aerapay account email
payer.address | *Object* | 
payer.address.street | *String* | Street name
payer.address.postal | *String* | Postal code
payer.address.city | *String* | City
payer.address.state | *String* | State 
payer.address.country | *String* | Country 
payer.nationality | *String* | Nationality of the payer
attachment | *Object* | Your defined attachment

__(4) Result Codes__

Code | Description
------|------------
21 | Payment confirmed
22 | Payment canceled
24 | Payment failed

## 4. Complete your payment

#### POST /complete
**Content-Type:** application/json

__Request__

Field | Type | Required | Description
------|------------|------------|------------
token | *String* | Yes | Payment token

__Response__

Field | Type | Description
------|------------|------------
token | *String* | Token to identitfy and access payment
result.code | *Number* | *Result codes* (6)
result.message | *String* | Detailed message
payment | *Object* | 
payment.id | *Object* | Identifier of the payment
payment.status | *String* | *Payment status* (3)
payment.method | *String* | *Payment methods* (5)
payment.currency | *String* | *Currencies*¹
payment.total | *String* | Total amount of the payment
payment.fee | *String* | Total fees for the merchant
payer | *Object* | 
payer.id | *String* | Aerapay account number
payer.username | *String* | Aerapay username
payer.first_name | *String* | First name
payer.last_name | *String* | Last name
payer.account_type | *String* | *Account types* (7)
payer.email | *String* | Aerapay account email
payer.address | *Object* | 
payer.address.street | *String* | Street name
payer.address.postal | *String* | Postal code
payer.address.city | *String* | City
payer.address.state | *String* | State 
payer.address.country | *String* | Country 
payer.nationality | *String* | Nationality of the payer
attachment | *Object* | Your defined attachment

__(6) Result Codes__

Code | Description | HTTP Status
------|------------|------------
13 | Authentication failed | 400
29 | Payment token invalid | 400
27 | Completion successful | 200
28 | Completion failed | 400

## References

__(1) Currencies__

Value | Description
------|------------
AUD | Australian Dollar
CAD | Canadian Dollar
CNY | Yuan Renminbi
EUR | Euro
GBP | British Pound
HKD | Hong Kong Dollar
SGD | Singapore Dollar
USD | US Dollar

__(3) Payment status__

Value | Description
------|------------
pending | Awaiting payer confirmation
in progress | Awaiting payment completion
awaiting | Successful but awaiting bank transfer
settling | Successful but awaiting settlement
settled | Successful and settled
canceled | Has been canceled
failed | Has failed
expired | Expired

__(5) Payment methods__

Value | Description
------|------------
credit | Debit / Credit Card 
transfer | Aerapay Transfer
bank | Bank Transfer

__(7) Account types__

Value | Description
------|------------
personal | Personal Account 
company | Corporate Account
