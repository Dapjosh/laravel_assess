
## Assess App

A laravel rest api that allows an admin send invitation link to a user. The user then fills the form, confirm submission with a 6 digit pin and is then registered successfully. User can also update their profile by adding their username and upload their avatar

**App Process**

Admin sends an invite link with,

/api/invitations/[POST]

It takes in the users email address and send a mail to that address to register

Required form input parameter

-Email

User registers with that link which is in the form of:

/api/user/register

The required form input is:

- Email
- Password
- Password Confirmation 
- Name 

After that, they are sent their 6 digit pin. 

This pin would later be an input to be entered in Postman to finish registration through the link also sent in the email.

The link follows: /api/user/register/final/{6digitpin} - where 6 digit pin is like 123456

After registration, user can now sign with the login endpoint and the returned

- Email 
- Password

The payload for that user is returned which also includes the app_token that can be used as a bearer token in Postman or any other api client.

---

**The endpoints available**

**Admin sends invitations**

```/api/invitations/  --- Admin sends an invite [POST]```


**Admin Registration**

```/api/admin/register --- This is the route for an admin to register.[POST]```


**User Registration**

```/api/user/register --- Endpoint for user to register [POST]```


**Login**

```/api/login --- Endpoint for both user and admin to login [POST]```

**Update Profile**

```/api/profile/3 -- Endpoint to update profile [POST] ```

*Must use a query parameter of attribute _method and value of PUT*

Required parameters are the username and avatar(the image must of the format jpg,jpeg,png,gif or svg and have dimension of 256 x 256px)

**Delete Profile**

```/api/profile/3 -- Endpoint to delete profile [DELETE]```

**Retrieve Profile**

```/api/profile/3 -- Endpoint to retrieve profile [GET]```


**Logout**

```/api/login --- Endpoint for both user and admin to logout [POST]```


