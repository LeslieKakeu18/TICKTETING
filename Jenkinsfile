pipeline {
    agent any

    stages {
        stage('📥 Checkout du code') {
            steps {
                git credentialsId: 'github_pat', url: 'https://github.com/LeslieKakeu18/TICKTETING.git'
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
                    docker-compose up -d db
                    echo "⏳ Attente de MySQL..."
                    timeout 60 bash -c "until docker exec ticketing-db mysqladmin ping -h db --silent; do sleep 2; done"

                    docker-compose run --rm app bash -c ^
                    "php artisan config:clear && ^
                    php artisan config:cache && ^
                    php artisan migrate --force && ^
                    php artisan test"
                '''
            }
        }

        stage('🚀 Déploiement Docker') {
            when {
                expression {
                    currentBuild.currentResult == 'SUCCESS'
                }
            }
            steps {
                echo '🚢 Lancement des containers Docker...'
                bat 'docker-compose up -d --force-recreate --remove-orphans'
            }
        }
    }

    post {
        failure {
            echo '❌ Le pipeline a échoué.'
        }
    }
}
