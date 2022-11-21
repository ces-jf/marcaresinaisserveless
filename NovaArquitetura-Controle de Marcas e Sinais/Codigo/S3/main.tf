resource "aws_s3_bucket" "b" {
  bucket = "front-angular-s3"

  tags = {
    Name        = "Front Angular S3"
    Environment = "Dev"
  }
}

resource "aws_s3_bucket_acl" "angular" {
  bucket = aws_s3_bucket.b.id
  acl    = "private"
}