import { faker } from '@faker-js/faker'

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
  activity: faker.helpers.arrayElement([
    'Projets',
    'Audiences',
    'Tutoriels',
  ]),
}))

export const services = [
  {
    id: 1,
    title: 'COUR CONSTITUTIONNELLE',
    description: 'Elle est l\'organe régulateur du fonctionnement des institutions et de l\'activité des pouvoirs publics',
    backgroundImage: '/assets/img/services/cour-constitutionnelle-removebg-preview.png',
    overlayColor: '#1e3a8a', // Bleu foncé
    logo: '/assets/img/services/cour-constitutionnelle-removebg-preview.png',
    link: 'https://courconstitutionnelle.bj/'
  },
  {
    id: 2,
    title: 'COUR SUPRÊME',
    description: 'C\'est la plus haute juridiction de l\'État en matière administrative, judiciaire et des comptes de l\'État',
    backgroundImage: '/assets/img/services/coursupreme.png',
    overlayColor: '#991b1b', // Rouge foncé
    logo: '/assets/img/services/coursupreme-removebg-preview.png',
    link: 'https://www.coursupreme.bj/'
  },
  {
    id: 3,
    title: 'ANIP',
    description: 'L\'ANIP assure la modernisation du processus d\'identification des personnes sur le territoire national',
    backgroundImage: '/assets/img/services/ANIP.jpeg',
    overlayColor: '#065f46', // Vert foncé
    logo: '/assets/img/services/ANIP-removebg-preview.png',
    link: 'https://www.anip.bj/'
  },
  {
    id: 4,
    title: 'Partis Politiques',
    description: 'Portail de l\ensemble des partis politiques du Bénin',
    backgroundImage: '/assets/img/services/portail_des_partis_politiques.png',
    overlayColor: '#92400e', // Orange foncé
    logo: '/assets/img/services/portail_des_partis_politiques-removebg.png',
    link: 'https://portailpartispolitiques.bj/'
  }
]

export const galleryItems = [
  {
    id: 1,
    title: ' Rencontre Cena et Ministères et Institutions impliqués dans le processus électorale',
    description: '',
    imageUrl: '/assets/img/events/event_8.jpg',
    date: '2025-08-28',
  },
  {
    id: 2,
    title: 'Rencontre de la CENA avec une délégation de la 12ᵉ promotion des Jeunes Leaders du Bénin',
    description: '',
    imageUrl: '/assets/img/events/event_7.jpg',
    date: '2025-08-28',
  },
  {
    id: 3,
    title: ' Visite de travail d’une délégation de la Direction Générale des Élections de la République de Guinée Conakry',
    description: '',
    imageUrl: '/assets/img/events/event_6.jpg',
    date: '2025-09-02',
  },
  {
    id: 4,
    title: ' Dépôt en ligne du dossier de demande d\'accréditation et l\'exploitation de l\'espace eAccréditation ',
    description: '',
    imageUrl: '/assets/img/events/event_5.jpg',
    date: '2025-09-04',
  },
  {
    id: 5,
    title: "Rencontre avec les Organisations de la Société Civile,  les confessions religieuses et les médias.",
    description: "Conformément à son chronogramme,  la Commission électorale nationale autonome (CENA), a tenu le mercredi 6 août 2025 à la Salle Fleuve Jaune du Ministère des Affaires étrangères une rencontre avec les représentants des OSC, des confessions religieuses et des médias pour faire un point d’étape du processus électoral en cours.",
    date: "2025-08-07",
    imageUrl: "/assets/img/events/event_4.jpg",
  },
  {
    id: 6,
    title: "CALENDRIER DE PASSAGE DES ÉQUIPES DE LA CENA DANS LE CADRE DE LA RÉCEPTION DES DOSSIERS PHYSIQUES DE CANDIDATURES DES MEMBRES DE POSTE DE VOTE DANS LES 77 COMMUNES DU BÉNIN.",
    description: "Le dépôt de dossiers physiques ne concerne pas ceux qui se sont inscrits en ligne et ont eu leurs récépissés.",
    date: "2025-09-04",
    imageUrl: "/assets/img/events/event_3.jpg"
  },
  {
    id: 7,
    title: "Le calendrier électoral est rendu public par le Président de la CENA",
    description: "La CENA a officiellement dévoilé le chronogramme des élections générales de 2026, lors d’une cérémonie à son siège à Cotonou ce mardi 15 avril 2025.",
    date: "2025-04-15",
    imageUrl: "/assets/img/events/event_2.jpg",
  },
  {
    id: 8,
    imageUrl: "/assets/img/events/event_1.jpg",
    title: "Visite à la GDIZ : La CENA enthousiaste, explore des pistes de partenariat avec la SIPI-Bénin",
    description: "Une forte délégation de la Commission Électorale Nationale Autonome (CENA) s'est rendue ce mercredi 9 juillet 2025 à la Zone industrielle de Glo-Djigbé (GDIZ). L'objectif était de constater de visu les réalisations de la Zone et d'explorer les possibilités de partenariat avec la Société d'Investissement et de Promotion de l'Industrie du Bénin (SIPI-Bénin).",
    date: "2025-07-11"
  },

]