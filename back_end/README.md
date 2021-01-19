in apache\bin folder
httpd -k start

elastic beanstalk will create a new user to manage the instance instead of your user, need to add access for the new user to do dynamo/s3 stuff

add this policy into s3 bucket for public access
{"Version": "2008-10-17",
"Statement": [{"Sid": "AllowPublicRead",
"Effect": "Allow",
"Principal": {
"AWS": "*"
},
"Action": "s3:GetObject",
"Resource": "arn:aws:s3:::seanbucket1313/*"
}]}