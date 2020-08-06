<?php
    namespace App\Service;



    use Symfony\Component\Finder\Exception\AccessDeniedException;
    use Symfony\Component\HttpFoundation\File\Exception\FileException;
    use Symfony\Component\HttpFoundation\File\UploadedFile;
    use Symfony\Component\String\Slugger\SluggerInterface;

    class FileUploadService
    {
        private $targetDirectory;
        private $slugger;

        public function __construct($targetDirectory, SluggerInterface $slugger)
        {
            $this->targetDirectory = $targetDirectory;
            $this->slugger = $slugger;
        }

        public function upload(UploadedFile $file){
            $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $this->slugger->slug($originalFileName);
            $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

            try {
                $file->move($this->getTargetDirectory(), $fileName);
            } catch (FileException $e) {
                $e->getMessage("Error has occured.");
            }

            return $fileName;
        }

        public function getTargetDirectory()
        {
            return $this->targetDirectory;
        }
    }
