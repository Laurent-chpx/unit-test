pipeline {
    agent any

    environment {
        DOCKER_IMAGE = "ghcr.io/laurent-chpx/unit-test"
        GITHUB_CREDENTIALS = '61a964e2-98e6-496f-99c9-a6ac0be52a88'
        BUILD_VERSION = "${BUILD_NUMBER}"
    }

    stages {
        stage('Checkout') {
            steps {
                echo 'Récupération du code source'
                git branch: 'main',
                    url: 'https://github.com/Laurent-chpx/unit-test.git'
            }
        }

        stage('Construction de l\'image Docker') {
            steps {
                echo 'Construction de l\'image Docker avec dépendances'
                sh '''
                    docker build -f Dockerfile.PHPunit2 -t ${DOCKER_IMAGE}:${BUILD_VERSION} .
                    docker tag ${DOCKER_IMAGE}:${BUILD_VERSION} ${DOCKER_IMAGE}:latest
                '''
            }
        }

        stage('Exécution des tests') {
            steps {
                echo 'Lancement des tests PHPUnit'
                sh '''
                    docker run --rm ${DOCKER_IMAGE}:${BUILD_VERSION}
                '''
            }
        }

        stage('Tag Git') {
            steps {
                echo 'Création du tag Git'
                script {
                    withCredentials([usernamePassword(
                        credentialsId: "${GITHUB_CREDENTIALS}",
                        usernameVariable: 'GIT_USERNAME',
                        passwordVariable: 'GIT_PASSWORD'
                    )]) {
                        sh '''
                            git config user.email "jenkins@chipaux.com"
                            git config user.name "Jenkins CI"
                            git tag -a v${BUILD_VERSION} -m "Version ${BUILD_VERSION} - Build automatique - Jenkinsfile"
                            git push https://${GIT_USERNAME}:${GIT_PASSWORD}@github.com/Laurent-chpx/unit-test.git v${BUILD_VERSION}_Jenkinsfile
                        '''
                    }
                }
            }
        }

        stage('Push vers GitHub Packages') {
            steps {
                echo 'Envoi de l\'image vers GitHub Container Registry'
                script {
                    withCredentials([usernamePassword(
                        credentialsId: "${GITHUB_CREDENTIALS}",
                        usernameVariable: 'GIT_USERNAME',
                        passwordVariable: 'GIT_PASSWORD'
                    )]) {
                        sh '''
                            echo "${GIT_PASSWORD}" | docker login ghcr.io -u "${GIT_USERNAME}" --password-stdin
                            docker push ${DOCKER_IMAGE}:${BUILD_VERSION}
                            docker push ${DOCKER_IMAGE}:latest
                            docker logout ghcr.io
                        '''
                    }
                }
            }
        }
    }
}