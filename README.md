## PHP OAuth2.0 flow implementation
Installation guide.

Follow the instruction below:

1. Download the repo on your machine
2. The query file in the sql folder contain the database schemas
3. The data folder contains the sample data
4. The query.php can be used to add the sample data to the database

### In this project
CLIENT: The app that want to access business data
BUSINESS: This is the account type used in this flow.
PRODUCT: this is the data owned by the business i.e products belong to the business

The client app wants to access the business data, but in other to do that, needs 
1. To be AUTHORIZED by the business account
2. The business owner needs to CONSENT
3. If account owner consent to business data access, a access token will be sent back to the redirected URL
4. The access token can be used to make API call to the data

Here is an image illustrating the flow
![OAuth2.0 Flow ](oauth.png)

Though this project illustrate business data authorization, it can be adapted to other request