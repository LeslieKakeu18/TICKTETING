pipeline {
    agent any

    environment {
        IMAGE_NAME = "laravel-app"
    }

    stages {
        stage('📥 Checkout du code') {
            steps {
                git branch: 'master', url: 'https://github.com/LeslieKakeu18/TICKTETING.git'
            }
        }

        stage('🐳 Build Docker') {
            steps {
                bat 'docker-compose build'
            }
        }

           stage('🧪 Lancer les tests') {
                steps {
                    bat 'docker-compose run --rm app bash -c "cp .env.docker .env && composer install --no-interaction && php artisan test"'
                }
            }




        stage('🚀 Déploiement') {
            steps {
                bat 'docker-compose up -d'
            }
        }
    }

    post {
        success {
            echo "✅ Déploiement réussi !"
        }
        failure {
            echo "❌ Le pipeline a échoué."
        }
    }
}
