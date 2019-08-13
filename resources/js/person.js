'use strict';

const countries = require('../data/countries');

module.exports = class Person {
    constructor(id, name, avatar, email, bio, team, position, countryCode) {
        this.country = {
            name: '',
            code: '',
        };

        this.id = id;
        this.name = name;
        this.avatar = avatar;

        this.email = email || '';

        this.bio = bio || '';
        this.team = team || '';
        this.position = position || '';

        if (countryCode) {
            this.country = {
                code: countryCode,
                name: countries[countryCode],
            }
        }
  }
};
