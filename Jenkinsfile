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
                    timeout /T 20

                    docker-compose run --rm app sh -c "php artisan config:clear && php artisan migrate --force && php artisan test"
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
