# Checkout with Aerapay

The Aerapay Checkout method allows merchants to receive payments within the Aerapay platform and gives buyers another way to pay. Online shoppers can pay with their Aerapay balance or credit card. The following shows the integration on your e-Commerce system.

###### In the Aerapay Checkout flow, the buyer:

1. Chooses Aerapay Checkout by clicking Checkout with Aerapay
2. Logs into Aerapay to authenticate his or her identity
3. Selects a payment method and reviews the transaction on Aerapay
4. Confirms the order and pays from your site
5. Receives an order confirmation

###### In the Aerapay Checkout, the merchant's application:

1. Submits all payment details to Aerapay via `POST` to `/checkout` and receives a payment token
2. Redirects the buyer to the Aerapay checkout page
3. Recieves result, and if successful payment and payer information
4. Updates the payment details optional via `POST` to `/update`
5. Completes the payment via `POST` to `/complete`

## 1. Submit payment details

#### POST /checkout

__Request__

Field | Type | Required | Description
------|------------|------------|------------
redirect | *String* | Yes | Redirect url for payment result
merchant | *Object* | No | 
merchant.name | *String* | No | Name of the merchant
merchant.email | *String* | No | Support email address 
merchant.website | *String* | No | URL of the merchant's website 
merchant.image | *String* | No | URL to the merchant's logo
order | *Object* | Yes | 
order.currency | *String* | Yes | 3 Letter currency code
order.total | *String* | Yes | Total amount of the order
order.shipping | *String* | No | Total shipping costs 
order.items | *Array* | No | 
order.items[n].id | *String* | No | Identifier of the item
order.items[n].name | *String* | No | Name of the item
order.items[n].amount | *String* | No | Amount of the item
order.items[n].quantity | *String* | No | Number of items
attachment | *Object* | No | Will be attached to each response

__Response__

Field | Type | Description
------|------------|------------
token | *String* | Token to identitfy and access payment
result | *Object* | 
result.code | *Number* | Result code
result.message | *String* | Detailed message

__Result Codes__

Code | Description
------|------------
13 | Authentication failed
20 | Payment approved
31 | Payment rejected
44 | Validation error
57 | Invalid total
