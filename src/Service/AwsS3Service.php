<?php
namespace App\Service;
use Aws\S3\S3Client;
use Psr\Log\LoggerInterface;
/**
 * This service should be used instead of AmazonS3Service.
 *
 * Class AwsS3Service
 * @property LoggerInterface logger
 * @property string bucket
 * @property S3Client client
 * @package AppBundle\Service
 */
class AwsS3Service
{
    public const AWS_S3_FILE_PRIVACY_READ_PUBLIC = 'public-read';
    public const AWS_S3_FILE_PRIVACY_PRIVATE = 'private';
    public const AWS_PRE_SIGNED_URI_TIME = '+120 minutes';
    public const AWS_GET_OBJECT_COMMAND = 'GetObject';
    public const AWS_COMMAND_INDEX_BUCKET = 'Bucket';
    public const AWS_COMMAND_INDEX_KEY = 'Key';

    /**
     * AwsS3Service constructor.
     * @param $awsKey
     * @param $awsSecret
     * @param $awsRegion
     * @param $awsSdkVersion
     * @param $awsS3bucket
     */
    public function __construct(
        $awsKey,
        $awsSecret,
        $awsRegion,
        $awsSdkVersion,
        $awsS3bucket
    ) {
        $this->setBucket($awsS3bucket);
        $this->setClient(new S3Client([
            'region' => $awsRegion,
            'version' => $awsSdkVersion
        ]));
    }

    /**
     * @param $fileName
     * @param $content
     * @param array $meta
     * @param string $privacy
     * @return bool
     */
    public function upload(
        $fileName,
        $content,
        array $meta = [],
        string $privacy = self::AWS_S3_FILE_PRIVACY_PRIVATE
    ):bool {
        try {
            return $this->getClient()->upload($this->getBucket(), $fileName, $content, $privacy)->toArray();
        } catch (\Exception $exception) {
            $this->logger->error('S3 file upload failed: ', [$exception]);
            return false;
        }
    }

    /**
     * @param string $fromBucket
     * @param string $fromKey
     * @param string $toBucket
     * @param string $toKey
     * @return string|bool
     */
    public function copy(
        string $fromBucket,
        string $fromKey,
        string $toBucket,
        string $toKey
    ) {
        try {
            return $this->getClient()->copy(
                $this->getBucket(),
                $fromBucket . '/'. $fromKey,
                $this->getBucket(),
                $toBucket . '/' . $toKey);
        } catch (\Exception $exception) {
            $this->logger->error('S3 file copy failed: ', [$exception]);
            return false;
        }
    }

    /**
     * @param $fileName
     * @param null $newFilename
     * @param array $meta
     * @param string $privacy
     * @return bool
     */
    public function uploadFile(
        $fileName,
        $newFilename = null,
        array $meta = [],
        string $privacy = self::AWS_S3_FILE_PRIVACY_PRIVATE
    ): bool
    {
        if (!$newFilename) {
            $newFilename = basename($fileName);
        }
        if (!isset($meta['contentType'])) {
            // Detect Mime Type
            $mimeTypeHandler = finfo_open(FILEINFO_MIME_TYPE);
            $meta['contentType'] = finfo_file($mimeTypeHandler, $fileName);
            finfo_close($mimeTypeHandler);
        }
        return $this->upload($newFilename, file_get_contents($fileName), $meta, $privacy);
    }

    /**
     * Getter of client
     * @return S3Client
     */
    protected function getClient(): S3Client
    {
        return $this->client;
    }

    /**
     * Setter of client
     * @param S3Client $client
     * @return $this
     */
    private function setClient(S3Client $client): AwsS3Service
    {
        $this->client = $client;
        return $this;
    }

    /**
     * Getter of bucket
     * @return string
     */
    protected function getBucket(): string
    {
        return $this->bucket;
    }

    /**
     * Setter of bucket
     * @param string $bucket
     * @return $this
     */
    private function setBucket(string $bucket): AwsS3Service
    {
        $this->bucket = $bucket;
        return $this;
    }

    /**
     * Check file exist status on AWS S3
     * @param string $fileName
     * @return bool
     */
    public function getKeyExistOnS3(string $fileName): bool
    {
        return $this->getClient()->doesObjectExist($this->getBucket(), $fileName);
    }

    /**
     * @param $key
     * @return string
     */
    public function getPreSignedUrl($key): string
    {
        $command = $this->getClient()->getCommand(
            self::AWS_GET_OBJECT_COMMAND,
            [
                self::AWS_COMMAND_INDEX_BUCKET => $this->getBucket(),
                self::AWS_COMMAND_INDEX_KEY => $key,
            ]
        );
        $request = $this->getClient()->createPresignedRequest($command, self::AWS_PRE_SIGNED_URI_TIME);

        return (string)$request->getUri();
    }

    /**
     * @param $key
     * @return string|bool
     */
    public function delete($key)
    {
        try {
            return $this->getClient()->deleteObject([
                'Bucket' => $this->getBucket(),
                'Key' => $key
            ]);
        } catch (\Exception $exception) {
            return false;
        }
    }
}