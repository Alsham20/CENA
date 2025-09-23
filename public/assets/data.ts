import { faker } from '@faker-js/faker'

export const news = Array.from({ length: 200 }, () => ({
  id: faker.string.uuid(),
  title: 'Ut velit mauris, egestas sed, gravida nec, ornare ut, mi. Aenean ut orci vel massa suscipit pulvinar. Nulla sollicitudin. Fusce varius, ligula non tempus aliquam',
  imageUrl: faker.helpers.arrayElement([
    '/src/assets/img/news/news1.jpg',
    '/src/assets/img/news/news2.jpg',
    '/src/assets/img/news/news3.jpg',
    '/src/assets/img/news/news4.jpg',
    '/src/assets/img/news/news5.jpg',
  ]),
  date: faker.date.past(),
}))

export const videos = Array.from({ length: 200 }, () => ({
  id: faker.lorem.lines(3),
  title: faker.helpers.arrayElement([
    'RÉCEPTION DE LA LEI PAR LA CENA: SACCA LAFIA FIER DE L\'ABOUTISSEMENT HEUREUX',
    'MESSAGE DU PRÉSIDENT DE LA CENA SACCA LAFIA SUR LE LANCEMENT DU SCRUTIN DU 8 JANVIER 2023',
    'REUNION CRUCIALE ENTRE LA CENA ET LA HAAC'
  ]),
  youtubeId: faker.helpers.arrayElement([
    'rCuVW7py4YU',
    'ifTICSDU2q8',
    'OJiDjW55T-o',
  ]),
  date: faker.date.past(),
  category: faker.helpers.arrayElement([
    'Réunion',
    'Actualité',
    'Scrutin',
    'Événement',
  ]),
}))

export const services = [
  {
    id: 1,
    title: 'COUR CONSTITUTIONNELLE',
    description: 'Elle est l\'organe régulateur du fonctionnement des institutions et de l\'activité des pouvoirs publics',
    backgroundImage: 'src/assets/img/services/cour-constitutionnelle-removebg-preview.png',
    overlayColor: '#1e3a8a', // Bleu foncé
    logo: 'src/assets/img/services/cour-constitutionnelle-removebg-preview.png',
    link: 'https://courconstitutionnelle.bj/'
  },
  {
    id: 2,
    title: 'COUR SUPRÊME',
    description: 'C\'est la plus haute juridiction de l\'État en matière administrative, judiciaire et des comptes de l\'État',
    backgroundImage: '/src/assets/img/services/coursupreme.png',
    overlayColor: '#991b1b', // Rouge foncé
    logo: '/src/assets/img/services/coursupreme-removebg-preview.png',
    link: 'https://www.coursupreme.bj/'
  },
  {
    id: 3,
    title: 'ANIP',
    description: 'L\'ANIP assure la modernisation du processus d\'identification des personnes sur le territoire national',
    backgroundImage: '/src/assets/img/services/ANIP.jpeg',
    overlayColor: '#065f46', // Vert foncé
    logo: '/src/assets/img/services/ANIP-removebg-preview.png',
    link: 'https://www.anip.bj/'
  },
  {
    id: 4,
    title: 'Partis Politiques',
    description: 'Portail de l\ensemble des partis politiques du Bénin',
    backgroundImage: '/src/assets/img/services/portail_des_partis_politiques.png',
    overlayColor: '#92400e', // Orange foncé
    logo: '/src/assets/img/services/portail_des_partis_politiques-removebg.png',
    link: 'https://portailpartispolitiques.bj/'
  }
]

export const resources = Array.from({ length: 200 }, () => ({
  id: faker.string.uuid(),
  title: faker.lorem.sentence(),
  size: faker.number.int({ min: 15, max: 5000 }),
  type: faker.helpers.arrayElement([
    'Cadre légal',
    'Décisions',
    'Communiqués de presse',
    'Rapports',
    'Discours',
  ]),
  publishedAt: faker.date.past(),
}))
