pipeline {
    agent any

    stages {
        stage('📥 Checkout du code') {
            steps {
                git credentialsId: 'DOCKER_HUB_CREDENTIALS', url: 'https://github.com/LeslieKakeu18/TICKETING.git'
            }
        }

        stage('📦 Build Docker') {
            steps {
                bat 'docker-compose build'
            }
        }

        stage('🧪 Lancer les tests') {
            steps {
                bat '''
                    docker-compose run --rm app bash -c ^
                    "php artisan config:clear && ^
                    php artisan key:generate && ^
                    php artisan config:cache && ^
                    php artisan migrate --force && ^
                    php artisan test"
                '''
            }
        }

        stage('🚀 Déploiement') {
            when {
                expression {
                    currentBuild.currentResult == 'SUCCESS'
                }
            }
            steps {
                echo "Déploiement en cours..."
                // Tes étapes de déploiement ici
            }
        }
    }

    post {
        failure {
            echo '❌ Le pipeline a échoué.'
        }
    }
}
