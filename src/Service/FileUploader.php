<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{
    public function __construct(
        private string $uploadsDirectory,
        private SluggerInterface $slugger,
    ) {
    }

    /**
     * Upload un fichier dans un sous-répertoire spécifique
     * 
     * @param UploadedFile $file Le fichier à uploader
     * @param string $subdirectory Le sous-répertoire (ex: 'articles', 'posts', 'users')
     * @return string Le nom du fichier généré
     */
    public function upload(UploadedFile $file, string $subdirectory = ''): string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

        // Déterminer le répertoire cible
        $targetDirectory = $subdirectory 
            ? $this->uploadsDirectory . '/' . $subdirectory
            : $this->uploadsDirectory;

        // Créer le répertoire s'il n'existe pas
        if (!is_dir($targetDirectory)) {
            mkdir($targetDirectory, 0755, true);
        }

        try {
            $file->move($targetDirectory, $fileName);
        } catch (FileException $e) {
            throw new FileException('Erreur lors de l\'upload du fichier : ' . $e->getMessage());
        }

        return $fileName;
    }

    /**
     * Supprime un fichier uploadé
     */
    public function delete(string $fileName, string $subdirectory = ''): bool
    {
        $targetDirectory = $subdirectory 
            ? $this->uploadsDirectory . '/' . $subdirectory
            : $this->uploadsDirectory;

        $filePath = $targetDirectory . '/' . $fileName;

        if (file_exists($filePath)) {
            return unlink($filePath);
        }

        return false;
    }

    public function getUploadsDirectory(): string
    {
        return $this->uploadsDirectory;
    }
}